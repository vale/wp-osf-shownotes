<?php

if (is_admin()) {
    add_action('admin_menu', 'shownotes_create_menu');
    add_action('admin_init', 'shownotes_register_settings');
}

function shownotes_settings_page() {
?>
 <div class="wrap">
    <h2> Shownotes Options</h2>
    <form method="post" action="options.php">
      <?php
    settings_fields('shownotes_options');
?>
     <?php
    do_settings_sections('shownotes');
?>
     <p class="submit">
       <input name="Submit" type="submit" class="button button-primary" value="<?php
    esc_attr_e('Save Changes');
?>" />
      </p>
    </form>
  </div>
<?php
}


function shownotes_create_menu() {
    add_options_page(' Shownotes Options', ' Shownotes', 'manage_options', 'shownotes', 'shownotes_settings_page');
}

function shownotes_register_settings() {
    $ps = 'shownotes';

    $settings = array(
        'affiliate' => array(
            'title' => 'Affiliate',
            'fields' => array(
                'amazon' => 'Amazon',
                'thomann' => 'Thomann',
                'tradedoubler' => 'Tradedoubler'
            )
        ),
        'export' => array(
            'title' => 'Export mode',
            'fields' => array(
                'mode' => 'select style'
            )
        ),
        'info' => array(
            'title' => 'Information',
            'function' => true
        )
    );

    register_setting('shownotes_options', 'shownotes_options');

    foreach ($settings as $sectionname => $section) {
        $function = false;
        if (isset($section['function'])) {
            $function = $ps . '_' . $sectionname;
        }
        add_settings_section($ps . '_' . $sectionname, $section['title'], $function, $ps);
        if (isset($section['fields'])) {
            $i = 0;
            foreach ($section['fields'] as $fieldname => $description) {
                $i += 1;
                add_settings_field($ps . '_' . $sectionname . '_' . $fieldname, $description, $ps . '_' . $sectionname . '_' . $fieldname, $ps, $ps . '_' . $sectionname, array(
                    'label_for' => 'ps' . $sectionname . $i
                ));
            }
        }
    }
}


function shownotes_affiliate_amazon() {
    $options = get_option('shownotes_options');
    if (!isset($options['affiliate_amazon'])) {
        $options['affiliate_amazon'] = "";
    }
    print "<input id='affiliate_amazon' name='shownotes_options[affiliate_amazon]' 
    value='" . $options['affiliate_amazon'] . "' style='width:8em;' />";
}

function shownotes_affiliate_thomann() {
    $options = get_option('shownotes_options');
    if (!isset($options['affiliate_thomann'])) {
        $options['affiliate_thomann'] = "";
    }
    print "<input id='affiliate_thomann' name='shownotes_options[affiliate_thomann]' 
    value='" . $options['affiliate_thomann'] . "' style='width:8em;' />";
}

function shownotes_affiliate_tradedoubler() {
    $options = get_option('shownotes_options');
    if (!isset($options['affiliate_tradedoubler'])) {
        $options['affiliate_tradedoubler'] = "";
    }
    print "<input id='affiliate_tradedoubler' name='shownotes_options[affiliate_tradedoubler]' 
    value='" . $options['affiliate_tradedoubler'] . "' style='width:8em;' />";
}

function shownotes_completeness_fullmode() {
    $options = get_option('shownotes_options');
    $checked = "";
    if (isset($options['completeness_fullmode']))
        $checked = "checked ";
    print "<input id='completeness_fullmode' name='shownotes_options[completeness_fullmode]' 
    $checked type='checkbox' value='1' />";
}

function shownotes_export_mode() {
    $options = get_option('shownotes_options');
    $modes = array('anycast', 'wikigeeks');
    print '<select id="export_mode" name="shownotes_options[export_mode]">';
    foreach($modes as $mode) {
        if($mode == $options['export_mode']) {
            print '<option selected>'.$mode.'</option>';
        } else {
            print '<option>'.$mode.'</option>';
        }
    }
    print "<select/>";
}

function shownotes_info() {
    $scriptname = explode('/wp-admin', $_SERVER["SCRIPT_FILENAME"]);
    $dirname    = explode('/wp-content', dirname(__FILE__));
    print '<p>This is <strong>Version 0.0.4</strong> of the <strong> Shownotes</strong>.<br>
  The <strong>Including file</strong> is: <code>wp-admin' . $scriptname[1] . '</code><br>
  The <strong>plugin-directory</strong> is: <code>wp-content' . $dirname[1] . '</code></p>
  <p>Want to contribute? Found a bug? Need some help? <br/>you can found our github repo/page at
  <a href="https://github.com/SimonWaldherr/wp-osf-shownotes">github.com/SimonWaldherr/wp-osf-shownotes</a></p>
  <p>If you found a bug, please tell us your WP- and ps- (and PPP- if you use PPP) Version. <br/>Also your 
  Browser version, your PHP version and the URL of your Podcast can help us, find the bug.</p>';
}

?>