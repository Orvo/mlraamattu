module.exports = function(grunt)
{
	//Initializing the configuration object
	grunt.initConfig({

		// Task configuration
		concat: {
			options: {
				separator: ';',
			},
			js: {
				src: [
					'public/js/plugins.js',
					'public/js/main.js',
				],
				dest: 'public/build/js/scripts.js',
			},
		},
		uglify: {
			options: {
				mangle: false,
			},
			js: {
				files: {
					'public/build/js/scripts.js': 'public/build/js/scripts.js',	
				},
			},
		}, 
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			target: {
				files: {
					'output.css': ['foo.css', 'bar.css']
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
	
};