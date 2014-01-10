function go(site, target) {
	target = (typeof target == 'undefined' ? '#content' : target);
	$(target).load("ajax.php?site="+site);
	return false;
}
