"use strict";

module.exports = function(grunt) {

    require("matchdep").filterDev("grunt-*").forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        // Define Directory
        dirs: {
            lib:     "public/assets/lib",
            js:      "public/assets/js",
            sjs:     "src/js",
            coffee:  "src/coffee",
            less:    "src/less",
            css:     "public/assets/css",
            img:     "public/assets/images"
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
        },
        // Notifications
        notify: {
          coffee: {
            options: {
              title: "CoffeeScript - <%= pkg.title %>",
              message: "Compiled and minified with success!"
            }
          },
          less: {
            options: {
              title: "LESS - <%= pkg.title %>",
              message: "Compiled and minified with success!"
            }
          },
          js: {
            options: {
              title: "Javascript - <%= pkg.title %>",
              message: "Minified and validated with success!"
            }
          },
          image: {
            options: {
                title: "Images - <%= pkg.title %>",
                message: "Optimized images with success!"
           }
          },
          watch: {
              options: {
                title: "Watch - <%= pkg.title %>",
                message: "Watching with success!"
              }
          }
        }
});


    // Register Taks
    // --------------------------

    // Observe changes, concatenate, minify and validate files
    grunt.registerTask( "default", [ "coffee", "notify:coffee", "less", "notify:less", "uglify", "notify:js", "imagemin", "notify:image" ]);

    // Run Server
    grunt.registerTask( "server", [ "default", "watch", "notify:watch"]);

    // Optimize Images
    grunt.registerTask( "img", [ "imagemin", "notify:image" ]);

};