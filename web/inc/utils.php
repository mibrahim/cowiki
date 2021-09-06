<?

function getSites()
{
    $res = query("select distinct(site) as site from pages");
    $sites = [];

    while ($row = $res->fetchArray())
        $sites[] = $row['site'];

    return $sites;
}

function childPagesList($site, $parent, $padding = 0)
{
    $sql = "select * from pages where ";
    if ($parent != null) $sql .= " parent=$parent ";
    else $sql .= " site='" . es($site) . "' and parent is null ";
    $sql .= "order by title";

    $html = "";

    $res = query($sql);
    while ($row = $res->fetchArray()) {
        $html .= "<a class='ms-$padding' href='/?pageid=$row[key]'>" . es($row['title']) . "</a><br/>\n";
        $html .= childPagesList($site, $row['key'], $padding + 2);
    }

    return $html;
}
