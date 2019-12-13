var __PSBtnClass = 'btn btn-light text-center d-inline-block px-3 py-1';
var __PSBtnClassSelect = 'border-dark';
var __PSPrev = '&lt;';
var __PSNext = '&gt;';
var __PSLimit = 10;

function __PSFilter(ps){
	
	let $childs = ps.getChilds();
	let page = ps.page;
	let limit = ps.limit;
	
	
	let $searchField = ps.getSearchField();
	if(!$searchField || $searchField.length == 0){
		alert("Search field not found");
	}
	let search = null;
	if($searchField && $searchField.length > 0) {
		search = $searchField.val().trim().replace("  ", " ").toLowerCase().split(" ");
	}
	
	let childCount = $childs.length;
	if(childCount == 0) return;
	
	let searchQueries = ps.searchQueries;
	
	let wordCount = search.length;
	
	let resultCount = 0;
	
	$childs.each(function(){
		let $child = $(this);
		
		let found = 0;
		if(search && search.length > 0 && search[0] && search[0] != ''){
			let $searchElements = __PSGetChildSearch($child, searchQueries);
			
			
			let s = "";
			$searchElements.each(function(){
				let $it = $(this);
				if($it.is("input")){
					s = s + $it.val();
				}else{
					s = s + $it.html();
				}
				let $inputs = $it.find("input");
				if($inputs.length > 0){
					$inputs.each(function(){
						s = s + " " + $(this).val();
					});
				}
			});
			
			s = s.toLowerCase();
			
			for(let j = 0; j < wordCount; ++j){
				if(s.includes(search[j])){
					console.log("this string includes: " + s);
					++found;
				}else if(search[j] == "d"){
					console.log("This string doesn't include 'd': " + s);
				}
			}
		}else{
			found = wordCount;
		}
		
		
		if(found >= wordCount){
			resultCount++;
			$child.removeClass("filtered-out");
		}else{
			$child.removeClass("filtered-out").addClass("filtered-out");
		}
		
	});
	
	$childs.filter(".filtered-out").addClass("d-none");
	ps.buildPagination();
}

function __PSRefresh(ps){
	$childs = ps.getChilds().not(".filtered-out");
	
	let no = 0;
	let page = ps.page;
	let limit = ps.limit;
	let start = (ps.page-1)*ps.limit+1;
	let max = start+limit-1;
	
	$childs.each(function(){
		++no;
		if(start <= no && no <= max){
			$(this).removeClass("d-none");
		}else{
			$(this).addClass("d-none");
		}
	});
}


function __PSSetPage(ps, page){
	let curPage = ps.page;
	let pageCount = ps.pageCount;
	if(page > pageCount) page = pageCount;
	if(page < 1) page = 1;
	if(page == curPage) return;
	ps.page = page;
	$paginationDiv = ps.getPaginationDiv();
	$paginationDiv.find(".pagination[data-page=\"" + curPage + "\"]")
		.removeClass(ps.classBtnSelect);
	$paginationDiv.find(".pagination[data-page=\"" + page + "\"]")
		.addClass(ps.classBtnSelect);
	ps.refresh();
}

function __PSGetChilds(ps){
	let queries = ps.childQueries;
	let lq = queries.length;
	let $childs = ps.$element.children(queries[0]);
	for(let i = 1; i < lq; ++i){
		$childs = $childs.add(ps.$element.children(queries[i]));
	}
	return $childs;
}

function __PSGetChildSearch($child, queries){
	let lq = queries.length;
	let $searches = $child.find(queries[0]);
	let isSelf = $child.is(queries[0]);
	for(let i = 1; i < lq; ++i){
		isSelf = isSelf || $child.is(queries[i]);
		let $found = $child.find(queries[i]).not(".d-none");
		if($found.length > 0){ 
			$searches = $searches.add($found);
		}
	}
	if(isSelf) $searches.add($child);
	return $searches;
}

function __PSBuildPagination(ps){
	
	let $paginationDiv = ps.getPaginationDiv();
	let childCount = ps.getChilds().not(".filtered-out").length;
	let limit = ps.limit;
	let pageCount = parseInt(Math.ceil(childCount / limit));
	ps.pageCount = pageCount;
	
	if(pageCount == 0){
		$paginationDiv.empty();
		return;
	}
	if(pageCount == 1){
		$paginationDiv.empty();
		ps.refresh();
		return;
	}
		
	
	let $btnPrev = $("<button></button>");
	$btnPrev.addClass(ps.classBtn);
	$btnPrev.html(ps.textBtnPrev);
	$btnPrev.click(function(){
		ps.prev();
	});
	let $btnNext = $("<button></button>");
	$btnNext.addClass(ps.classBtn);
	$btnNext.html(ps.textBtnNext);
	$btnNext.click(function(){
		ps.next();
	});
	
	
	
	let curPage = ps.page;
	if(curPage < 0) curPage = 0;
	if(curPage > pageCount) curPage = pageCount;
	ps.page = curPage;
	
	let btnNums = [];
	for(let i = 1; i <= pageCount; ++i){
		let $btnNum = $("<button></button>");
		$btnNum.addClass(ps.classBtn).addClass("pagination");
		$btnNum.html(i);
		$btnNum.attr("data-page", i);
		$btnNum.data("page", i);
		if(i == curPage){
			$btnNum.addClass(ps.classBtnSelect);
		}
		$btnNum.click(function(){
			ps.setPage(i);
		});
		btnNums.push($btnNum);
	}
	
	$paginationDiv.empty();
	$paginationDiv.append($btnPrev);
	for(let i = 0; i < pageCount; ++i){
		$paginationDiv.append(btnNums[i]);
	}
	$paginationDiv.append($btnNext);
	
	
	ps.refresh();
}

class PaginationSearch {
	
    constructor(option) {
		this.object = this;
		this.element = option.element;
		this.$element = $(option.element);
		this.classBtn = option.btnClass || __PSBtnClass;
		this.classBtnSelect = option.btnClassSelect || __PSBtnClassSelect;
		this.textBtnPrev = option.prev || __PSPrev;
		this.textBtnNext = option.next || __PSNext;
		this.limit = option.limit || __PSLimit;
		this.childQueries = option.childQueries || ["*"];
		this.searchQueries = option.searchQueries;
		this.searchField = option.searchField;
		this.paginationDiv = option.paginationDiv;
		this.page = 1;
		this.pageCount = 0;
		
		let ps = this;
		if(this.searchField){
			$(this.searchField).bind("change keyup paste", function(){
				ps.filter();
			});
		}
		
		this.init();
    }
	
	init(){
		this.filter();
	}
	
	filter(){
		__PSFilter(this);
	}
	
	buildPagination(){
		__PSBuildPagination(this);
	}
	next(){
		if(this.page < this.pageCount)
			this.setPage(this.page+1);
	}
	prev(){
		if(this.page > 1)
			this.setPage(this.page-1);
	}
	getPaginationDiv(){
		return $(this.paginationDiv);
	}
	getSearchField(){
		return $(this.searchField);
	}
	setPage(page){
		__PSSetPage(this, page);
	}
	getChilds(){
		return __PSGetChilds(this);
	}
	refresh(){
		__PSRefresh(this);
	};
	
}

function CreatePaginationSearch(option){
	let ps = new PaginationSearch(option);
	
	ps.$element.data("PaginationSearch", ps);
}