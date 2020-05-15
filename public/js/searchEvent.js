var searchBar = document.querySelector('.searchBar__searchField');

var searchLayout = document.querySelector('.searchLayout'); 

searchBar.addEventListener('focus', function(e){
	searchLayout.classList.add("searchLayout--show");
	searchBar.parentNode.classList.add("relative--scale")
});

searchBar.addEventListener('blur', function(e){
	console.log("I'm blurred");
	searchLayout.classList.remove("searchLayout--show");
	searchBar.parentNode.classList.remove("relative--scale")
});

var searchForm = document.querySelector('.searchBar__form');


var searchIcon = document.querySelector('.searchBar__icon');

searchIcon.addEventListener('click', function(e){
	e.preventDefault();
	searchForm.submit(); 
})