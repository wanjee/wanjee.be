'use strict';

module.exports = function (grunt) {

    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.initConfig({
        cssmin: {
            options: {
                shorthandCompacting: false,
                roundingPrecision: -1,
                sourceMap: true,
                // Disable merge of properties and selectors
                advanced: false
            },
            app: {
                files: {
                    'web/css/app.min.css': [
                        'web/css/app/styles.css'
                    ]
                }
            },
            vendors: {
                files: {
                    'web/css/vendors.min.css': [
                        // do not use *.js as order is important
                        'web/css/vendors/bootstrap.min.css'
                    ]
                }
            }
        },
        compass: {
            app: {
                options: {
                    sassDir: 'web/scss',
                    cssDir: 'web/css/app',
                    environment: 'development',
                    noLineComments: true,
                    outputStyle: 'nested',
                    sourcemap: true,
                    imagesDir: 'web/img',
                    http_path: 'web',
                    relativeAssets: true
                }
            }
        },
        jshint: {
            app: {
                src: ['web/js/app/*.js']
            }
        },
        uglify: {
            options: {
                mangle: false,
                sourceMap: true
            },
            app: {
                files: {
                    'web/js/app.min.js': [
                        'web/js/app/main.js',
                        'web/js/app/effects.js'
                    ]
                }
            },
            vendors: {
                files: {
                    'web/js/vendors.min.js': [
                        'web/js/vendors/jquery.min.js',
                        'web/js/vendors/bootstrap.min.js'
                    ]
                }
            }
        },
        'watch': {
            styles: {
                files: 'web/scss/**/*.scss',
                tasks: ['compass','cssmin:app'],
                options: {
                    debounceDelay: 250
                }
            },
            scripts: {
                files: 'web/js/app/**',
                tasks: ['jshint', 'uglify:app'],
                options: {
                    interrupt: true
                }
            }
        }
    });

    grunt.registerTask('default', [
        'dist',
        'watch'
    ]);

    grunt.registerTask('dist', [
        'compass',
        'cssmin',
        'uglify'
    ]);
};
