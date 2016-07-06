require('dotenv').config();

module.exports = function(grunt) {

  var package  = grunt.file.readJSON('package.json');
  var sassFile = 'theme/style.sass';

  // Project configuration.
  var options = {
    pkg: package
  };


  options.watch = {
    theme: {
      files: ['theme/**','!'+sassFile],
      tasks: ['copy:theme'],
      options: {
        livereload: true,
      }
    },
    sass: {
      files: [sassFile],
      tasks: ['sass']
    }
  };


  options.copy = {
    themeAll: {
      expand: true,
      cwd: 'theme',
      src: ['**'],
      dest: process.env.THEME_FOLDER_PATH+package.name
    },
    theme: {
      expand: true,
      cwd: 'theme',
      src: ['**','!images/**', '!bower_components/**'],
      dest: process.env.THEME_FOLDER_PATH+package.name
    },
    plugin: {
      expand: true,
      cwd: 'plugin',
      src: ['**'],
      dest: process.env.PLUGIN_FOLDER_PATH+package.name      
    }
  };


  options.sass = {
    dist: {
      files: {
        'theme/style.css': sassFile
      }
    }
  };


  options.php = {
    test: {
      options: {
        keepalive: true,
        open: true,
        port: 8111
      }
    }
  };


  options.uglify = {
    global: {
      files: {
        'theme/global.min.js': [
          'theme/bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
          'theme/bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
          'theme/bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js'
        ]
      }
    }
  };


  options['ftp-deploy'] = {
    build: {
      auth: {
        host:     process.env.FTP_HOST,
        username: process.env.FTP_USERNAME,
        password: process.env.FTP_PASSWORD,
        port: 21
      },
      src: 'theme',
      dest: package.name,
      forceVerbose: true,
      exclusions: ['theme/bower_components', 'theme/images']
    }
  };

  grunt.initConfig(options);
  require('load-grunt-tasks')(grunt);

  // Default task(s).
  grunt.registerTask('default', ['watch']);

  grunt.registerTask('ftp', ['ftp-deploy']);
  grunt.registerTask('copyAll',['copy:themeAll']);

};