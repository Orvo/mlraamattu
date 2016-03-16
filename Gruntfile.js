module.exports = function(grunt)
{
	//Initializing the configuration object
	grunt.initConfig({

		// Task configuration
		concat: {
			options: {
				separator: ';',
			},
			js_public: {
				src: [
					'public/js/main.js',
				],
				dest: 'public/js/public-dist.js',
			},
			js_admin: {
				src: [
					'public/js/ng/main.js',
					'public/js/ng/controllers.js',
					'public/js/ng/models.js',
				],
				dest: 'public/js/admin-ng-dist.js',
			},
		},
		uglify: {
			options: {
				mangle: false,
			},
			js_public: {
				files: {
					'public/js/public-dist.min.js': 'public/js/public-dist.js',	
				},
			},
			js_admin: {
				files: {
					'public/js/admin-ng-dist.min.js': 'public/js/admin-ng-dist.js',
					'public/js/admin-dist.min.js': 'public/js/admin.js',
				},
			},
		}, 
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			public: {
				files: {
					'public/css/public-dist.min.css': ['public/css/main.css', 'public/css/mobile.css']
				}
			},
			admin: {
				files: {
					'public/css/admin-dist.min.css': ['public/css/admin.css']
				}
			}
		},
		phpunit: {
			classes: {
			},
			options: {
			}
		},
		watch: {
			js: {
				files: [
					'public/js/plugins.js',
					'public/js/main.js',
				],
				tasks: ['concat:js', 'uglify:js'],
			},
		}
	});

	// Plugin loading
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-phpunit');
	
	// Task definition
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('thing', ['concat', 'cssmin', 'uglify']);
	
};