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
            //    banner: '*//*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> *//*\n',
                // prevent changes to your variable and function names.
                mangle: false,
                // beautify your code for debugging/troubleshooting purposes
                beautify: true
        },
            my_target: {
                files: {
                    // we specify that we exclude the min.js files
                    'web/assets/output.min.js': ['app/Resources/scripts/*.js']
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
                    'web/assets/main.css': ['app/Resources/stylesheets/*.scss', 'app/Resources/stylesheets/*.sass', 'app/Resources/stylesheets/*.css']       // 'destination': 'source'

                }
            }
        },

        // watch configuration
        watch: {
            // watch task for scripts
            scripts: {
                // watch if any .js files change in the scripts folder
                files: ['app/Resources/scripts/*.js'],
                // run these tasks when the watch event triggers
                tasks: ['uglify'],
                options: {
                    // Setting this option to false speeds up the reaction time of the watch (usually 500ms faster for most)
                    // and allows subsequent task runs to share the same context.
                    spawn: false,
                    // react to all events 'changed', 'added' and 'deleted'.
                    event: ['all']
                }
            },
            // watch task for stylesheets
            stylesheets: {
                // watch if any .scss files change in the views folder
                files: ['app/Resources/stylesheets/*.scss', 'app/Resources/stylesheets/*.sass'],
                // run these tasks when the watch event triggers
                tasks: ['sass'],
                options: {
                    // Setting this option to false speeds up the reaction time of the watch (usually 500ms faster for most)
                    // and allows subsequent task runs to share the same context.
                    spawn: false,
                    // react to all events 'changed', 'added' and 'deleted'.
                    event: ['all']
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

    // Watch plugin, runs predefined tasks whenever watched file patterns are added, changed or deleted.
    grunt.loadNpmTasks('grunt-contrib-watch');

    /*---------------- DEFAULT TASKS --------------------*/
	
    // Default task(s).
    // These tasks will be automaticly executed when the grunt command is run
    grunt.registerTask('default', ['uglify', 'sass', 'watch']);

};
