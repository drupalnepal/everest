module.exports = {
  dev : {
    files: [
      { expand: true, cwd: "assets/src/font/", src: ["**"], dest: "assets/build/font/" }
    ]
  },
  prod: {
    files: [
      { expand: true, cwd: "assets/src/font/", src: ["**"], dest: "assets/build/font/" }
    ]
  }
};
