Symfony2.8 To-do Challenge by Filippo Capurso
=============
Project started Friday 30th September 2016

## Technologies Used
### Symfony 2.8 (Required)
Since I was new to this platform, it took me a couple of days to get around it's structure.
Though after runnign the app on the local server and using a couple of command lines to create
prestructured directories, I quickly understood the requirements and locations of specific files.
After getting used to the environment, I started noticing several advantages that cut down building,
updating and debugging time.
### FOSUserBundle (Required)
This Bundle was great since it takes only a couple of minutes to obtain a very well structured and secure user log management.
It provides several features, some of which I didn't exploit, but would be gret for future implementation.
Although i found several obstacles when trying to overwrite some default features (such as the views).
This was probably one of the steps that took longer for me to implement. Then again i was expecting it since
it was the first feature I included in this new environment
### Doctrine ORM
I didn't have experience with Doctrine or any of it's object mappers. Therefore I chose to go with the standard ORM
instead of downloading additional bundles. I think this was a good choice because now I will be able to compare
new bundles to this standard and understand their specific advantages. Also the database function weren't complex
at all so I believe that the benefits of integrating an additional bundle wouldn't have been critical.
### Jquery 1.12
I was planning to use an altearnative to standard Jquery, in particular Umbrella JS. Although I quickly
realized the available time i had to complete the challenge was very tight, so I prefered opting towards having a
functionally complete app rather than an original but incomplete one.
### Bootstrap 3.3
I chose to use this version because I initially wanted to implement some features in my app, in particular glyphicons,
that other versions don't have. Unfortunately I ran out of time to include them, so in the end it didn't make a difference.
### LAMP
Initially I was running an Ubuntu virtual machine with LAMP already included. The whole system was working fine and I
was discovering several quick ways of setting up structures for Synfony. Though the next day, my computer crashed and
I had to use light editor, such as VS CODE, on borrowed machines. On the other hand I will probably opt towards using
LAMP to develop my future Synfony apps.

## Setup
The system should be set up in order to be run locally with the inbuilt PHP server. In the following link you can find
all the steps to set deploy the application.

[How to Deploy a Symfony2.8 Application](http://symfony.com/doc/2.8/deployment.html)

## Overall Considerations

The sections of this project that took greatly more time than I was expecting to get through were
the modification of the default views (and initially controllers) of the FOSUserBundle and translating the PHP
response objects so that they could be read in the frontend Ajax callback function.

The first obstacle was overcome by creating an _Acme_ bundle directory in addition to the AppBundle. This is most probably
not the best way to overwrite such files, but it was the method that had the most online documentation. As for the second
obstacle, it took much longer than expected since I initially refused to distribute manually the response objects and
their values in an array. Though after a long online search and a suprising lack of answers that made sense, I eventually
gave up in order to complete the other functions and possibily return to it later.

The _Acme_ bundle directory only includes the UserBundle used only to define the User.php entity and overwrite
some of the FOSUserBundle views. It doens't have any controllers or additional files and was specifically created
to redifine some default FOSUserBundle files (as explained in the previous section). As a consequence, almost
all of my Ajax requests are handled in a single controller (_MainController_) in order to keep things consistent.

If i had more time available, I would definitely go through the code again to simplify some of my syntax and would update
the structrure so that it adheres with Synfony's best practices. Of course, this app would benifit from the integration
of other technologies (such as Doctrine object mapping Bundles, _React_, _Umbrella Js_ , etc.) and improving its UI.