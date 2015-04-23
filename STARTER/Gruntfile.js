module.exports = function( grunt ) {

  // Measures the time each task takes.
  require( "time-grunt" )( grunt );

  // Load grunt config.
  require( "load-grunt-config" )( grunt, {
    data: {
      dev_path       : "assets/dev/",
      dist_path      : "assets/dist/",
      js_path        : "assets/src/js/",
      js_dev_path    : "assets/dev/js/",
      js_dist_path   : "assets/dist/js/",
      font_path      : "assets/src/font/",
      font_dev_path  : "assets/dev/font/",
      font_dist_path : "assets/dist/font/",
      img_path       : "assets/src/img/",
      img_dev_path   : "assets/dev/img/",
      img_dist_path  : "assets/dist/img/",
      scss_path      : "assets/src/scss/"
    }
  });
};
