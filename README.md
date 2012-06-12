# Haml for CakePHP (v0.1)

This plugin for the CakePHP Framework allows you to use the Haml Templating Language.

Apart from enabling you to use most of Haml syntax the plugin is tightly integrated with 
the CakePHP view renderer giving you full access to helpers, objects.

## Current Status

The view class itself is pretty solid, however not all sorts of Haml^Cake has been thrown at it yet.

The renderer is a copy of a [phpHaml fork i found on GitHub](https://github.com/glasserc/phphaml), 
which is maintained by glasserc. I chose it over the sourceforge original as it contains lots 
of contributed fixes.

Check out the **examples** directory. Converting entire CakePHP views looks perfectly possible, even at 
this early state. I am almost entirely happy with the outcome, but see for yourself.

## What's missing

- No support for elements (partials), yet.
- Haml comments are not removed (```-# some comment```)
- Some more tiny syntax stuff, see examples

## Getting the goods

    git clone --recursive git://github.com/m3nt0r/cakephp-haml-view.git haml
    
## Usage
  
  Add the View to your ```app_controller.php```
  
    class AppController extends Controller {
        public $view = 'Haml.Haml'; // use twig
    }
    
  Create ```.haml``` files inside your view folders
  
  
  