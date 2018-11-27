"use strict";

var gulp = require("gulp");
var sass = require("gulp-sass");

sass.compiler = require("node-sass");

gulp.task("css", function() {
	return gulp
		.src("./public/css/src/**/*.scss")
		.pipe(sass().on("error", sass.logError))
		.pipe(gulp.dest("./public/css"));
});

gulp.task("watch", function() {
	gulp.watch("./public/css/src/**/*.scss", ["sass"]);
});
