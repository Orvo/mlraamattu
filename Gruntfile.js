module.exports = function(grunt)
{
	//Initializing the configuration object
	grunt.initConfig({

		// Task configuration
		concat: {
			options: {
				separator: ';\n',
			},
			js_public: {
				src: [
					'resources/assets/js/public.js',
				],
				dest: 'public/js/build/public.min.js',
			},
			js_angular: {
				src: [
					// Third party modules
					'resources/assets/js/ng/modules/*.js',
					
					// Application code
					'resources/assets/js/ng/angular-main.js',
					'resources/assets/js/ng/controllers-main.js',
					'resources/assets/js/ng/controllers/*.js',
					'resources/assets/js/ng/models.js',
				],
				dest: 'public/js/build/admin-angular.min.js',
			},
			js_admin: {
				src: [
					'resources/assets/js/admin.js',
				],
				dest: 'public/js/build/admin.min.js',
			},
		},
		uglify: {
			options: {
				mangle: false,
			},
			js_public: {
				files: {
					'public/js/build/public.min.js': 'public/js/build/public.min.js',
				},
			},
			js_admin: {
				files: {
					'public/js/build/admin-angular.min.js': 'public/js/build/admin-angular.min.js',
					'public/js/build/admin.min.js': 'public/js/build/admin.min.js',
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
					'public/css/build/public.min.css': [
						'resources/assets/css/public.css',
						'resources/assets/css/courses-special.css',
						'resources/assets/css/public-mobile.css'
					],
				}
			},
			ckeditor: {
				files: {
					'public/css/build/ckeditor-additional.min.css': [
						'resources/assets/css/courses-special.css',
					],
				}
			},
			admin: {
				files: {
					'public/css/build/admin.min.css': [
						'resources/assets/css/admin.css',
					],
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
					'resources/assets/js/*.js',
					'resources/assets/js/ng/*.js',
					'resources/assets/js/ng/controllers/*.js',
				],
				tasks: [
					'concat',
					'uglify',
				],
			},
			css: {
				files: [
					'resources/assets/css/*.css',
				],
				tasks: [
					'cssmin',
				],
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
	grunt.registerTask('default', [
		'concat',
		'uglify',
		'cssmin',
		'watch'
	]);
	
	grunt.registerTask('build', [
		'concat',
		'uglify',
		'cssmin',
	]);
	
};