function go(site) {
	$("#content").load("ajax.php?site="+site);
	return false;
}