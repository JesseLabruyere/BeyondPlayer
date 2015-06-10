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
                banner: '*//*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> *//*\n',
                // prevent changes to your variable and function names.
                mangle: false,
                // beautify your code for debugging/troubleshooting purposes
                beautify: true
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
                    /*'main.css': 'app/Resources/views/*.scss',       // 'destination': 'source'
                    'widgets.css': 'widgets.scss'*/
                }
            }
        },

        // watch configuration
        watch: {
            scripts: {
                // watch if any .js files change in the scripts folder
                files: ['app/Resources/scripts/*.js', 'app/Resources/views/*.scss'],
                // run these tasks when the watch event triggers
                tasks: ['uglify', 'sass'],
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
