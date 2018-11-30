"use strict";

var gulp = require("gulp");
var sass = require("gulp-sass");
var concat = require("gulp-concat");
var uglify = require("gulp-uglify");

sass.compiler = require("node-sass");

gulp.task("css", function() {
	return gulp
		.src("./public/css/src/**/*.scss")
		.pipe(sass().on("error", sass.logError))
		.pipe(gulp.dest("./public/css"));
});

gulp.task("concat", function() {
	return gulp
			.src(["./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js", "./public/js/src/*.js"])
			.pipe(concat("landing-culturapopular.js"))
			.pipe(gulp.dest("./public/js"))
});

gulp.task("watch", function() {
	gulp.watch("./public/css/src/**/*.scss", ["sass"]);
	gulp.watch("./public/js/src/**/*.js", ["concat"]);
});
