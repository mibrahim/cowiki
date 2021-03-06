<?

function getSites()
{
    $res = query("select distinct(site) as site from pages where deleted=0");
    $sites = [];

    while ($row = $res->fetchArray())
        $sites[] = $row['site'];

    return $sites;
}

function childPagesList($site, $parent, $padding = 0)
{
    $sql = "select * from pages where deleted=0 and ";
    if ($parent != null) $sql .= " parent=$parent and key<>$parent ";
    else $sql .= " site='" . es($site) . "' and parent is null ";
    $sql .= "order by title";

    $html = "";

    $res = query($sql);
    while ($row = $res->fetchArray()) {
        $class = "";
        if (isset($_GET['pageid']) && $row['key'] == $_GET['pageid'])
            $class = "bg-secondary bg-gradient text-white fw-bold round";
        $html .= "<div class='ahover $class'><a class='ms-$padding $class' style='text-decoration: none;' href='?pageid=$row[key]'>" . es($row['title']) . "</a><br/></div>\n";
        $html .= childPagesList($site, $row['key'], $padding + 2);
    }

    return $html;
}

function deletePage($pageid)
{
    query("update pages set deleted=1 where key=$pageid");

    // Get all children
    $res = query("select * from pages where parent=$pageid");
    while ($row = $res->fetchArray())
        deletePage($row['key']);
}

function unDeletePage($pageid)
{
    query("update pages set deleted=0 where key=$pageid");

    // Get all children
    $res = query("select * from pages where parent=$pageid");
    while ($row = $res->fetchArray())
        unDeletePage($row['key']);
}
