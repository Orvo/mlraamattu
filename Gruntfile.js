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
				dest: 'public/js/public.min.js',
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
				dest: 'public/js/admin-angular.min.js',
			},
			js_admin: {
				src: [
					'resources/assets/js/admin.js',
				],
				dest: 'public/js/admin.min.js',
			},
		},
		uglify: {
			options: {
				mangle: false,
			},
			js_public: {
				files: {
					'public/js/public.min.js': 'public/js/public.min.js',	
				},
			},
			js_admin: {
				files: {
					'public/js/admin-angular.min.js': 'public/js/admin-angular.min.js',
					'public/js/admin.min.js': 'public/js/admin.min.js',
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
					'public/css/public.min.css': [
						'resources/assets/css/public.css',
						'resources/assets/css/public-mobile.css'
					],
				}
			},
			admin: {
				files: {
					'public/css/admin.min.css': [
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
					'resources/assets/css/main.css',
					'resources/assets/css/admin.css',
				],
				tasks: [
					'prepare',
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
	grunt.registerTask('default', ['watch']);
	grunt.registerTask('prepare', [
		'concat',
		'uglify',
		'cssmin',
	]);
	
};