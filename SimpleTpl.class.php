<?
        class SimpleTpl
        {
            private $stack;

            public function append($key, $value)
            {
                $this->stack[$key][] = $value;
            }

            public function merge($key, $value)
            {
                $this->stack[$key] = array_merge ( $this->stack[$key], $value );
            }

            public function assign($key, $value)
            {
                $this->stack[$key] = $value;
            }
     
            private function intValue($value)
            {
                $tokkens = preg_split('/(\[[0-9a-z-A-Z\$\.]+\])|\.|\$?([0-9a-zA-Z\$]+)/', $value , -1, PREG_SPLIT_DELIM_CAPTURE + PREG_SPLIT_NO_EMPTY);
                $current = $this->stack;
                
                foreach ($tokkens as $tokken)
                {
                    if (preg_match('/\[([0-9]+)\]/',$tokken,$m))
                    {
                        $current = $current[$m[1]];
                    }
                    else if (preg_match('/\[(.+)\]/',$tokken,$m))
                    {
                        $current = $current[intval($this->intValue($m[1]))];
                    }
                    else
                    {
                        $current = $current[$tokken];
                    }
                }
                return $current;
            }

            private function runtimeError($error)
            {
                die("ERROR: $error");
            }

            private function intParseParams($params)
            {
                $ret = array();
                preg_match_all("/([a-z]+)=([a-z0-9\$]+)/",$params,$matches);
                if (count($matches[1])>0)
                    for ($i=0; $i<=count($matches); $i++)
                        if ((isset($matches[1][$i])) && (isset($matches[2][$i])))
                            $ret[$matches[1][$i]]=$matches[2][$i];
                
                
                return $ret; 
            }

            private function intRender($tokkens)
            {
                $t = $tokkens;
                
                $eip = 0;

                $loops = array();

                $ret = array();

                while ($eip < count($t))
                {
                    if (preg_match('/{([\/a-z]+)(.*)}/',$t[$eip],$m))    # Straight variable names
                    {
                        $keyword = $m[1];
                        $params = $this->intParseParams($m[2]);

                        if ($keyword == "for")
                        {
                            if (!isset($params["name"]))
                                $this->runtimeError("Error, for-loop should have a name.");
                            
                            $name = $params["name"];
                            unset($loops[$name]);
                            $loops[$name]=$params; 

                            if (!isset($params["start"]))
                                $this->runtimeError("Error, for-loop should have a start value.");

                            if (!isset($params["stop"]))
                                $this->runtimeError("Error, for-loop should have a stop value.");

                            if (!isset($params["step"]))
                                    $loops[$name]["step"]=1; // If you do not supply a step value, asume 1

                            $loops[$name]["eip"]=$eip; 
                            $loops[$name]["count"]=$params["start"]; 
                            $this->stack[$name] = $loops[$name];
                        }

                        if ($keyword == "/for")
                        {
                            $name = end($loops)["name"];
                            
                            if ($loops[$name]["start"] < $loops[$name]["stop"]) // Vi taeller op
                            {
                                $loops[$name]["count"]=$loops[$name]["count"]+$loops[$name]["step"];
                
                                if ($loops[$name]["count"] <= $loops[$name]["stop"])
                                    $eip = $loops[$name]["eip"];
                                else
                                    array_pop($loops);
                            } 
                            elseif ($loops[$name]["start"] > $loops[$name]["stop"]) // Vi taeller ned 
                            {
                                $loops[$name]["count"]=$loops[$name]["count"]-$loops[$name]["step"]; 
                                
                                if ($loops[$name]["count"] >= $loops[$name]["stop"])
                                    $eip = $loops[$name]["eip"];
                                else
                                    array_pop($loops);
                            }
                            else    // vi taeller ikke 
                            {
                            
                            }
                            $this->stack[$name] = $loops[$name];
                        }

                        if ($keyword == "foreach")
                        {
                            if (!isset($params["name"]))
                                $this->runtimeError("Error, foreach-loop should have a name.");
                            $name = $params["name"];
                        
                            if (!isset($loops[$name]))  // First time
                            {
                                unset($loops[$name]);
                               
                               if (!isset($params["loop"]))
                                    $this->runtimeError("Error, foreach-loop should have a loop array.");

                                $loops[$name]["name"] = $name;
                                $loops[$name]["loop"] = substr($params["loop"],1); 
                                $loops[$name]["keys"] =array_keys($this->intValue($params["loop"]));
                                $loops[$name]["eip"] =$eip; 
                            }
                            $loops[$name]["index"] = array_shift($loops[$name]["keys"])."\n";
                            $this->stack[$name] = $loops[$name];
                        }

                        if ($keyword == "/foreach")
                        {
                            $name = end($loops)["name"];
                            if (count($loops[$name]["keys"])!=0)
                                $eip = $loops[$name]["eip"]-1;
                        }

                    } else {
                    if (preg_match('/{\$(.+)}/',$t[$eip],$m))
                    {
                        $ret[] = $this->intValue($m[1]);
                }
                else    
                    $ret[] = $t[$eip];
                }

                $eip++;
            }
            return $ret;
            }

        public function fetch($tpl)
        {
            $tokkens = preg_split('/({.+?})/', file_get_contents($tpl) , -1, PREG_SPLIT_DELIM_CAPTURE);
            $tokkens = $this->intRender($tokkens);

            return implode($tokkens);
        }

        public function display($tpl)
        {
            print $this->fetch($tpl);
        }
    }
?>
