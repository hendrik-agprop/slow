<?php
$project_meta_work_phases = get_field( 'project_meta_work_phases' );
$project_meta_team = get_field( 'project_meta_team' );
$project_meta_links = get_field( 'project_meta_links' );
?>

<dl class="list--vertical">
  <?php 
  /* Project Work Phases */
  if ( $project_meta_work_phases ) {
    echo '<dt>Leistungsphasen</dt>';

    foreach ( $project_meta_work_phases as $phase ) {
      echo '<dd>' . $phase['project_meta_work_phases_phase'] . '</dd>';
    }
  }

  /* Project Client */
  if ( $project_meta_client ) {
    $client_name = $project_meta_client['project_meta_client_name'];
    $client_url = $project_meta_client['project_meta_client_url'];

    if ( strlen( $client_name ) > 0 ) {
      echo '<dt>Auftraggeber</dt>';

      if ( strlen( $client_url ) > 0 ) {
        echo '<dd><a href="' . $client_url . '">' . $client_name . '</a></dd>';
      } else {
        echo '<dd>' . $client_name . '</dd>';
      }
    }
  }

  /* Project Team */
  if ( $project_meta_team ) {

    if ( sizeof( $project_meta_team ) == 0 ) {
      return false;
    }
    
    $managers = [];
    $participants = [];

    foreach ($project_meta_team as $member) {
      $member_infos = $member['project_meta_team_member'];
      $member_role = $member_infos['project_meta_team_member_role'];

      if ( $member_role == "manager" ) {
        array_push($managers, $member);
      } else {
        array_push($participants, $member);
      }
    }

    if ( sizeof($managers) > 0 ) { 
      echo '<dt>Projektleitung</dt>';
      foreach ($managers as $member) {
        $member_infos = $member['project_meta_team_member'];
        $member_type = $member_infos['project_meta_team_member_type'];
        $member_role = $member_infos['project_meta_team_member_role'];
        $member_name = $member_infos['project_meta_team_member_name'];
        $member_url = '';

        if ( $member_type === 'internal' ) {
          $user = $member_infos['project_meta_team_member_user'];
          $member_name = $user['user_firstname'] . ' ' . $user['user_lastname'];
        } else if ( $member_type === 'external' ) {
          $member_name = $member_infos['project_meta_team_member_name'];
          $member_url = $member_infos['project_meta_team_member_url'];
        }

        if ( strlen( $member_url ) > 0 ) {
          echo '<dd><a href="' . $member_url . '">' . $member_name . '</a></dd>';
        } else {
          echo '<dd>' . $member_name . '</dd>';
        }
      }
    }

    if ( sizeof($participants) > 0 ) { 
      echo '<dt>Team</dt>';
      foreach ($participants as $member) {
        $member_infos = $member['project_meta_team_member'];
        $member_type = $member_infos['project_meta_team_member_type'];
        $member_role = $member_infos['project_meta_team_member_role'];
        $member_name = $member_infos['project_meta_team_member_name'];
        $member_url = '';

        if ( $member_type === 'internal' ) {
          $user = $member_infos['project_meta_team_member_user'];
          $member_name = $user['user_firstname'] . ' ' . $user['user_lastname'];
        } else if ( $member_type === 'external' ) {
          $member_name = $member_infos['project_meta_team_member_name'];
          $member_url = $member_infos['project_meta_team_member_url'];
        }

        if ( strlen( $member_url ) > 0 ) {
          echo '<dd><a href="' . $member_url . '">' . $member_name . '</a></dd>';
        } else {
          echo '<dd>' . $member_name . '</dd>';
        }
      }
    }
  }

  /* Project Links */
  if ( $project_meta_links ) {
    echo '<dt>Weiterführende Links</dt>';

    foreach ( $project_meta_links as $link ) {
      $item = $link['project_meta_links_item'];
      $item_title = $item['project_meta_links_item_title'];
      $item_url = $item['project_meta_links_item_url'];

      if ( strlen( $item_title ) == 0 ) {
        $item_title = $item_url;
        $item_title = str_replace( 'http://', '', $item_title );
        $item_title = str_replace( 'https://', '', $item_title );

        if ( strlen( $item_title ) > 20 ) {
          $item_title = substr( $item_title, 0, 20 ) . '...';
        }
      }

      echo '<dd><a href="' . $item_url . '" target="_blank">' . $item_title . '</a></dd>';
    }
  }
  ?>
</dl>