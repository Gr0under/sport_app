const {series, watch, src, dest} = require('gulp');
const sassCompiler = require('gulp-sass');
const autoprefix = require('gulp-autoprefixer');
const rename = require('gulp-rename');

function compileScss(){
	return src('public/style/sass/main.scss')
	.pipe(sassCompiler())
	.pipe(autoprefix({
		cascade : false,
		grid : "no-autoplace",
		remove:true,
	}))
	.pipe(rename('main_prefix.css'))
	.pipe(dest('public/style/css'));
	
	
	        
}

function autoPrefix(){
	return src('public/style/css/auto.css')
	.pipe(autoprefix({
		cascade : false,
		grid : "autoplace"
	}))
	.pipe(rename('prefix.css'))
	.pipe(dest('public/style/css/'));
}



exports.prefix = function()
{
	watch('public/style/css/auto.css', series(autoPrefix)); 
}
exports.default = function()
{
	watch('public/style/sass/**/*.scss', series(compileScss));
} 
