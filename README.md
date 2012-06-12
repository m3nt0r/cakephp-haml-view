# Haml for CakePHP (v0.1)

This plugin for the CakePHP Framework allows you to use the Haml to create your views.

Haml? - XHTML Abstraction Markup Language.

> Haml is a markup language that’s used to cleanly and simply describe the XHTML of any web document, without the use of inline code.    Haml functions as a replacement for inline page templating systems such as PHP, ERB, and ASP. However, Haml avoids the need for explicitly coding XHTML into the template, because it is actually an abstract description of the XHTML, with some code to generate dynamic content.

## Current Status

The view class itself is pretty solid, however not all sorts of Haml^Cake has been thrown at it yet.

Check out the **examples** directory. Converting entire CakePHP views looks perfectly possible, even at 
this early state. I am almost entirely happy with the outcome, but see for yourself.

The renderer is a copy of a [phpHaml fork i found on GitHub](https://github.com/glasserc/phphaml), 
which is maintained by glasserc. I chose it over the sourceforge original as it contains lots 
of contributed fixes.

Furthermore, i've forked the phpHaml fork [myself](https://github.com/m3nt0r/phphaml) so i can extend
and fix it as i see fit. First thing i did was adding the new doctypes outlined in the official 
[HAML_REFERENCE](http://haml.info/docs/yardoc/file.HAML_REFERENCE.html).


## What's missing

- Haml comments are not removed (```-# some comment```)
- Some more tiny syntax stuff, see examples
- Multiline is a little bit weird
- ^ That includes spanning method calls over multiple lines

## Getting the goods

    git clone --recursive git://github.com/m3nt0r/cakephp-haml-view.git haml
    
## Usage
  
  Add the View to your ```app_controller.php```
  
    class AppController extends Controller {
        public $view = 'Haml.Haml'; // use twig
    }
    
  Create ```.haml``` files inside your view folders
  
  
  