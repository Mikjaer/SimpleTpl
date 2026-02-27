# SimpleTpl v.1.0

A lightweight PHP Template engine, designed to replace Smarty.

## Project goals:

- Warning-free, neat and easy understanbable (and thereby maintainable and extensible) code
- Small and durable solution for places where a true template enginge susch as Jinja2 is overkill

# FAQ

**Q: Why no {section}{/section} controlstructure?**  
A: It has been replace with {for} and {foreach}, the behaviour
   of a given function should not be dictated by it' parameters
   but by the functionname itself.

**Q: How do i get started?**  
A: Download example.php, example.tpl and SimpleTpl.class.php and
   read the code, play around with it, it's pretty self-explanatory.

   More details in getting-started.txt.

**Q: What's the license?**  
A: GNU GPL v2 or MIT BSD, i reserve the right to re-release the code and any contributions under
   a different license under my choosing. If you want this software under another license, please contact me.

**Q: Can i make money using this code?**  
A: Sure, just keep my name in the credits and drop me a line if you do.

**Q: What's the futue plans for this library? (2026)**  
A: I plan to PHP8-ify the code, and add Jinja2 like functions.