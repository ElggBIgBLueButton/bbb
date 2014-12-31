<?php

elgg_register_event_handler('init', 'system', 'bbb_init');

function bbb_init() {

    elgg_register_page_handler('bbb', 'bbb_page_handler'); // Manage pages
    add_group_tool_option('bbb', elgg_echo('Big Blue Button'), true); // Add option config in edit group
//  elgg_extend_view('bbb/tool_latest', 'bbb/group_module'); 
    elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'bbb_owner_block_menu'); // Add menu in group menu
    elgg_register_entity_type('object', 'bbb'); // Registeer Object
}

function bbb_page_handler() { // Set defaul and only page

	if (!isset($page[0])) {
		$page[0] = 'conecta'; 
	}
	elgg_push_breadcrumb(elgg_echo('bbb'), 'bbb/conecta');
	$pages = dirname(__FILE__) . '/pages/bbb';
	switch ($page[0]) {
		case 'conecta':
			elgg_group_gatekeeper();
			include "$pages/conecta.php";
			break;
		default:
			return false;
	}
	elgg_pop_context();
	return true;
}

function bbb_owner_block_menu($hook, $type, $return, $params) { // Add menu if is active in group options
	if ($params['entity']->bbb_enable != 'no') {
		$url = "bbb/group/{$params['entity']->guid}/conecta";
		$item = new ElggMenuItem('bbb', elgg_echo('Big Blue Button'), $url);
		$return[] = $item;
	}
	return $return;
}
