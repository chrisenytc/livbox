"use strict";

module.exports = function(grunt) {

    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // Define Directory
        dirs: {
            lib:     "assets/lib",
            js:      "assets/js",
            sjs:     "src/js",
            coffee:  "src/coffee",
            less:    "src/less",
            css:     "assets/css",
            img:     "assets/images"
        },

        // Metadata
        pkg: grunt.file.readJSON("package.json"),
        banner:
        "\n" +
        "/*\n" +
         " * -------------------------------------------------------\n" +
         " * Project: <%= pkg.title %>\n" +
         " * Version: <%= pkg.version %>\n" +
         " *\n" +
         " * Author:  <%= pkg.author.name %>\n" +
         " * Site:     <%= pkg.author.url %>\n" +
         " * Contact: <%= pkg.author.email %>\n" +
         " *\n" +
         " *\n" +
         " * Copyright (c) <%= grunt.template.today(\"yyyy\") %> <%= pkg.author.name %>\n" +
         " * -------------------------------------------------------\n" +
         " */\n" +
         "\n",

        // Observe Changes
        watch: {
            css: {
                files: ["<%= dirs.less %>/{,*/}*.less"],
                tasks: ["less", "notify:less"]
            },
            coffee: {
                files: ["<%= dirs.coffee %>/{,*/}*.coffee"],
                tasks: ["coffee", "notify:coffee", "uglify", "notify:js"]
            },
            js: {
                files: ["<%= dirs.sjs %>"],
                tasks: ["uglify", "notify:js"]
            }
        },

        coffee: {
            glob_to_multiple: {
              expand: true,
              flatten: false,
              cwd: '<%= dirs.coffee %>',
              src: ['*.coffee'],
              dest: '<%= dirs.sjs %>',
              ext: '.js'
            }
        },

        // Minify and Concat archives
        uglify: {
            options: {
                mangle: false,
                banner: "<%= banner %>"
            },
            dist: {
                files: {
                    "<%= dirs.js %>/app.min.js": [
                    "<%= dirs.sjs %>/app.js"
                    ],
                    "<%= dirs.js %>/controllers.min.js": [
                    "<%= dirs.sjs %>/controllers.js"
                    ]
                }
            }
        },

        // Compile LESS to CSS
        less: {
            dist: {
                options: {
                    // ieCompat: true, // Compatible with IE8
                    // report: 'gzip' // Verify LESS performance
                    banner: "<%= banner %>",
                    yuicompress: true // Compress CSS with cssmin.js
                },
                files: {
                    "<%= dirs.css %>/style.min.css": [
                    "<%= dirs.less %>/*.less"
                    ]
                }
            }
        },

        // Optimize Images
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 9,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: "<%= dirs.img %>/",
                    src: "<%= dirs.img %>/**",
                    dest: "<%= dirs.img %>/"
                }]
            }
        }
});


    // Register Taks
    // --------------------------

    // Observe changes, concatenate, minify and validate files
    grunt.registerTask( "default", [ "coffee", "less", "uglify", "imagemin" ]);

    // Run Server
    grunt.registerTask( "server", [ "default", "watch"]);

    // Optimize Images
    grunt.registerTask( "img", [ "imagemin" ]);

};
