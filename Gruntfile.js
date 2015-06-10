/**
 * Created by Jesse on 10-6-2015.
 */




module.exports = function(grunt) {

    /*---------------- CONFIGURATION --------------------*/
    // Project configuration.
    grunt.initConfig({

        // We get the package file
        pkg: grunt.file.readJSON('package.json'),

        // uglifying javascript Configuration
        uglify: {
            options: {
                // now we can use the package name in the banner of our minified file
                banner: '*//*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> *//*\n'
            },
            my_target: {
                files: {
                    'app/Resources/scripts/output.min.js': ['app/Resources/scripts/test1.js', 'app/Resources/scripts/test2.js']
                }
            }
        },

        // sass configuration
        sass: {                              // Task
            dist: {                            // Target
                options: {                       // Target options
                    style: 'expanded'
                },
                files: {                         // Dictionary of files
                    /*'main.css': 'main.scss',       // 'destination': 'source'
                    'widgets.css': 'widgets.scss'*/
                }
            }
        }

    });

    /*---------------- LOADING PLUGINS --------------------*/
    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-uglify');

    // Sass plugin that provides the "sass" task.
    // !Important This task requires you to have Ruby and Sass installed.
    grunt.loadNpmTasks('grunt-contrib-sass');



    /*---------------- DEFAULT TASKS --------------------*/
    // Default task(s).
    // These tasks will be automaticly executed when the grunt command is run
    // grunt uglify works in the command line but not as a default task
    grunt.registerTask('default', ['uglify']);


    // test default task
    grunt.registerTask('default', 'Log some stuff.', function() {
        grunt.log.write('Logging some stuff...').ok();
    });
    // 'Sass' task
    /*grunt.registerTask('default', ['sass']);*/

};
