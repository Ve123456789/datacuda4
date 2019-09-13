module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Configuration for the Sass task
        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                     'public/assets/css/datacuda.css': 'public/assets/css/datacuda.less'
                }
            }
         }

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-watch');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['watch']);

};