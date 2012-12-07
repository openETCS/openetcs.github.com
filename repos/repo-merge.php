<?php

$result = json_decode( file_get_contents( "repo-structure.json" ), true );
$githubDescription = json_decode( file_get_contents( "repo-description-github.json" ), true );
$additionalDescription = json_decode( file_get_contents( "repo-description-additions.json" ), true );

$found = false;
function findAndInsert( &$repoDescription, $newRepo ) {
  foreach( $repoDescription as &$repo ) {
    if( $repo[ "name" ] === $newRepo[ "name" ] ) {
      $repo = array_merge( $newRepo, $repo );
      $GLOBALS[ "found" ] = true;
    } elseif( isset( $repo[ "children" ] ) ) {
      findAndInsert( $repo[ "children" ], $newRepo );
    }
  }
}

function addRepo( &$repoDescription, $newRepo ) {
  $GLOBALS[ "found" ] = false;
  findAndInsert( $repoDescription, $newRepo );
  if( !$GLOBALS[ "found" ] ) {
    $repoDescription[] = $newRepo;
  }
}

foreach( $githubDescription as $repo ) {
  addRepo( $result, $repo );
}

foreach( $additionalDescription as $repo ) {
  addRepo( $result, $repo );
}

file_put_contents(
  "repo-description-merged.json",
  json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES )
);

?>