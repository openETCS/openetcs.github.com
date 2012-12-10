<?php

$result = readJsonAsArray( "repo-structure.json" );
mergeRepositoryData( $result, readJsonAsArray( "repo-description-github.json" ) );
mergeRepositoryData( $result, readJsonAsArray( "repo-description-additions.json" ) );

file_put_contents(
  "repo-description-merged.json",
  json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES )
);

# helpers
function readJsonAsArray( $fileName ) {
  return json_decode( file_get_contents( $fileName ), true );
}

function mergeRepositoryData( array &$mergeTarget, array $mergeSource ) {
  foreach( $mergeSource as $repo ) {
    addRepo( $mergeTarget, $repo );
  }
}

$found = false;
function addRepo( array &$repoDescription, array $newRepo ) {
  $GLOBALS[ "found" ] = false;
  findAndInsert( $repoDescription, $newRepo );
  if( !$GLOBALS[ "found" ] ) {
    $repoDescription[] = $newRepo;
  }
}

function findAndInsert( array &$repoDescription, array $newRepo ) {
  foreach( $repoDescription as &$repo ) {
    if( $repo[ "name" ] === $newRepo[ "name" ] ) {
      $repo = array_merge( $newRepo, $repo );
      $GLOBALS[ "found" ] = true;
      break;
    } elseif( isset( $repo[ "children" ] ) ) {
      findAndInsert( $repo[ "children" ], $newRepo );
    }
  }
}

?>