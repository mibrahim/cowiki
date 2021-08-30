<?

function getSites()
{
    $res = query("select distinct(site) as site from pages");
    $sites = [];

    while ($row = $res->fetchArray())
        $sites[] = $row;

    return $sites;
}
