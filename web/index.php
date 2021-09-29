<?php
require_once "inc/conf.php";
require_once "inc/utils.php";

$todo = filter_input(INPUT_POST, "todo");

if (isset($todo) && $todo == 'updatecontent') {
    $content = es(filter_input(INPUT_POST, "content"));
    $pageid = filter_input(INPUT_GET, "pageid");
    query("update pages set content='$content' where key=$pageid");
}

if (isset($todo) && $todo == 'updatetitle') {
    $title = es(filter_input(INPUT_POST, "title"));
    $pageid = filter_input(INPUT_GET, "pageid");
    query("update pages set title='$title' where key=$pageid");
}

if (isset($todo) && $todo == 'reparent') {
    $newParentID = es(filter_input(INPUT_POST, "newparent"));
    $pageid = filter_input(INPUT_GET, "pageid");
    if ($pageid != $newParentID)
        query("update pages set parent=$newParentID where key=$pageid");
}

if (isset($_GET['delete']) && $_GET['delete'] == '1') {
    $content = es(filter_input(INPUT_POST, "content"));
    $pageid = filter_input(INPUT_GET, "pageid");
    $row = query_row("select * from pages where key=$pageid");
    deletePage($pageid);
    header("Location: ?site=$row[site]");
    die();
}

if (isset($todo) && $todo == 'newpage') {
    $siteName = es(filter_input(INPUT_POST, "sitename"));
    $title = es(filter_input(INPUT_POST, "title"));

    query("insert into pages(site,title) values ('$siteName','$title')");

    $lastPageRow = query_row("select max(key) as max from pages");
    header("Location: ?pageid=$lastPageRow[max]");
    die();
}

if (isset($todo) && $todo == 'childpage') {
    $siteName = es(filter_input(INPUT_POST, "sitename"));
    $title = es(filter_input(INPUT_POST, "title"));
    $parentid = es(filter_input(INPUT_POST, "parentid"));

    query("insert into pages(site,title,parent) values ('$siteName','$title',$parentid)");
}

$sites = getSites();

$currentSite = filter_input(INPUT_GET, "site");
if ($currentSite == null) {
    $currentSite = "";
    if (sizeof($sites)) $currentSite = $sites[0];
}

$pageid = filter_input(INPUT_GET, "pageid");

$pagerow = null;
$Page['pageheading'] = "";

if (isset($pageid)) {
    $pagerow = query_row("select * from pages where key=$pageid");
    $currentSite = $pagerow['site'];
    $Page['title'] = "<title>" . $pagerow['title'] . "</title>";

    $Page['pageheading'] .= "
      <div class='p-4 mb-4 rounded bg-light bg-gradient' style='font-family: Josefin Sans, sans-serif;color:#444;'>
          <h1><a class='btn btn-success' onclick='edittitle(\"" . htmlentities($pagerow['title']) . "\");'><i class='fas fa-edit'></i> Edit</a>
          $pagerow[title]<div style='float:right;'>ID: #$pageid</div></h1>
      </div>\n";

    $Page['content'] = $pagerow['content'];

    // Does it have children?
    $hasChildren = query_row("select * from pages where parent=$pageid and deleted=0");
    if ($hasChildren != false) {
        $Page['extracontent'] .= "<hr/><h2>Contents</h2>";
        $Page['extracontent'] .= childPagesList(null, $pageid);
    }
}

$Page['buttons'] = "
<script>
    var currentSite = \"$currentSite\";
    var pageTitle = \"$pagerow[title]\";
</script>
";

$Page['buttons'] .= '
<a class="btn btn-primary" onclick="save()"><i class="fas fa-save"></i> Save</a>
<input type="hidden" name="updatecontent" value="Save">
<a class="btn btn-primary" onclick="newPage(currentSite)"><i class="fas fa-plus-circle"></i> New Page</a>
<a class="btn btn-primary" onclick="childPage(currentSite, pageTitle, ' . $pageid . ')"><i class="fas fa-plus-circle"></i> Child Page</a>
<a class="btn btn-primary" onclick="reparent(' . $pageid . ')"><i class="fas fa-cog"></i> Reparent</a>
<a class="btn btn-primary" onclick="edit()"><i class="fas fa-edit"></i> Edit</a>
<a class="btn btn-primary" href="?pageid=' . $pageid . '&delete=1" onclick="return confirm(' . "'Are you sure?'" . ')"><i class="fas fa-trash"></i> Delete</a>
';

$siteIcon = '<i class="fas fa-sitemap"></i>';

$Page['leftnav'] = '<form method="get"><table><tr><td><select id="site" name="site" class="form-select">';
foreach ($sites as $site) {
    $Page['leftnav'] .= "<option value='" . htmlentities($site, ENT_QUOTES) . "' ";
    if ($site == $currentSite) $Page['leftnav'] .= "selected";
    $Page['leftnav'] .= ">" . htmlentities($site) . "</option>\n";
}
$Page['leftnav'] .= '</select></td><td><input class="btn btn-success" type="submit" value="go"/></td></tr></table></form>';

if (isset($currentSite)) {
    $Page['leftnav'] .= childPagesList($currentSite, null);
}

$Page['debug'] .= "Number of queries: $queries<br/>";
$Page['debug'] .= "Total time: $totalQueryTime";

include "template.php";
