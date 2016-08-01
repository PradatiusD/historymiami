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
    plugin: {
      files: ['plugin/**'],
      tasks: ['copy:plugin'],
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
      dest: process.env.THEME_FOLDER_PATH + package.name
    },
    theme: {
      expand: true,
      cwd: 'theme',
      src: ['**','!images/**', '!bower_components/**'],
      dest: process.env.THEME_FOLDER_PATH + package.name
    },
    plugin: {
      expand: true,
      cwd: 'plugin',
      src: ['**'],
      dest: process.env.PLUGIN_FOLDER_PATH + package.name      
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
          'theme/bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
          'theme/bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js'
        ]
      }
    }
  };

  function ftpConfig (params) {

    var env = process.env;

    var location  = params.location.toUpperCase();
    var component = params.component;

    var options = {
      auth: {
        host:     env["FTP_"+location+"_HOST"],
        username: env["FTP_"+location+"_"+component.toUpperCase()+"_USERNAME"],
        password: env["FTP_"+location+"_"+component.toUpperCase()+"_PASSWORD"],
        port: 21
      },
      src: component.toLowerCase(),
      dest: package.name,
      forceVerbose: true,
      exclusions: params.exclusions || []
    };

    return options;
  }

  options['ftp-deploy'] = {
    "staging.theme": ftpConfig({
      location: "dev", 
      component: "theme",
      exclusions: ['theme/bower_components', 'theme/images','theme/lib']
    }),
    "staging.plugin": ftpConfig({
      location:"dev",
      component: "plugin"
    }),
    "production.theme": ftpConfig({
      location: "prod", 
      component: "theme",
      exclusions: ['theme/bower_components', 'theme/images','theme/lib']
    }),
    "production.plugin": ftpConfig({
      location: "prod", 
      component: "plugin"
    })
  };

  grunt.initConfig(options);
  require('load-grunt-tasks')(grunt);


  grunt.registerTask('default', ['watch']);
};
