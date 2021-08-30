<?php
require_once "inc/conf.php";
require_once "inc/utils.php";

$currentSite = filter_input(INPUT_GET, "site");
$pageid = filter_input(INPUT_GET, "pageid");

$pagerow = null;

if (isset($pageid)) {
    $pagerow = query_row("select * from pages where id=$pageid");
    $currentSite = $pagerow['site'];
}

$Page['buttons'] = '
<a class="btn btn-primary"><i class="fas fa-save"></i> Save</a>
<a class="btn btn-primary" onclick="' . "new('" . htmlentities($currentSite) . "')" . '"><i class="fas fa-plus-circle"></i> New</a>
<a class="btn btn-primary" onclick="edit()"><i class="fas fa-edit"></i> Edit</a>
';

$siteIcon = '<i class="fas fa-sitemap"></i>';

$sites = getSites();

$Page['leftnav'] = '<select id="sites" class="form-select">';
foreach ($sites as $site) {
    $Page['leftnav'] .= "<option value='" . htmlentities($site) . " ";
    if ($site == $currentSite) $Page['leftnav'] .= "selected";
    $Page['leftnav'] .= ">" . htmlentities($site) . "</option>\n";
}
$Page['leftnav'] .= '</select>';

include "template.php";
