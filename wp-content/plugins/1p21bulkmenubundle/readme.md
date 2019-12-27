# Documentation

## Functionalities
*	Bundle installs [ACF Nav menu fields](https://wordpress.org/plugins/advanced-custom-fields-nav-menu-field/) and [Quick Edit Fields](https://wordpress.org/plugins/acf-quickedit-fields/)
*	sets up a widget area for a default sidebar (for pages)
*	sets up a blog sidebar (for blog pages)
*	sets up parent or ancestor page sidebars that will be inherited by all descendants
*	adds ability to set a custom menu to individual pages via admin bulk edit or edit page



## How to install (the simple way)

1.	Check and make sure the following tasks are true for a smooth install

	- [x] *Advanced Custom Fields: Nav Menu Field* plugin is **NOT** activated (or make sure it's at version 2.0.0)

	- [x] *ACF QuickEdit Fields* plugin is **NOT** activated (or make sure it's at version 2.4.19)

	- [x]	*Sidebar Menu ACF Field group* (`'group_5c366a793a9df'`), or any fields or field groups that matches the field keys in this file [ilaw-nav-field-bulk-edit-support/fields/fields.php](ilaw-nav-field-bulk-edit-support/fields/fields.php) **DO NOT** exist in the back-end


2.	Install this boi
3.	go to *Admin > iLawyer Sidebar Settings > Subdirectory Sidebars* and setup appropriate subdirectory sidebars if needed
4.	go to *Admin > Appearance > Widgets* and setup or migrate contents of blog and default sidebars into the ilawyer setup sidebars
5.	Open index.php or theme template(s) that utilize sidebars in a text editor and remove all `dynamic_sidebar()` declarations and place `bulk_sidebar()` appropriately. Modify template code as needed as well.
6.	Migrate remaining sidebar content the setup. setup subdirectory widgets or custom sidebar menus as needed


## Render sidebar

To generate sidebar call on the function `bulk_sidebar()`

This function calls on a template that goes through all possible sidebars implemented by and through this plugin
	
Example:

Suppose we edit index.php, old code may look like this:

```
<aside>
	<?php if(is_home()){
		dynamic_sidebar('blog_sidebar');
	}else if(is_page(6669)){
		dynamic_sidebar('6669_sidebar');
	}else if(is_page(4)){
		dynamic_sidebar('4_sidebar');
	}else{
		dynamic_sidebar('default_sidebar');
	} ?>
</aside>
```

When the plugin is set up, it will register a widget area for pages, blogs, and custom parent sidebars or custom menus to individual pages with the single function:

```
<aside>
	<?php bulk_sidebar(); ?>
</aside>
```

In case the rendered content needs to be customized, the function calls on a boiler template: [ilaw-nav-field-bulk-edit-support/template/sidebar.php](ilaw-nav-field-bulk-edit-support/template/sidebar.php) which can be copied into your theme instead of using the function



## Functions aside from `bulk_sidebar`

### `bulk_get_default()`

Get default fallbacks for opts fields in case they are blank or not flushed

## Back end fields

### iLawyer Sidebar Settings

#### Settings

*	**Widget Class**

	Custom classes to add to widgets implemented and custom page sidebar menus

*	**Title Class**

	Custom classes to add to titles of widgets implemented and custom page sidebar menus

*	**Title Tag**

	html tag to be used by widgets implemented and custom page sidebar menus

*	**Default Title**

	Default title for custom page sidebar menus to default to

*	**Menu Depth**

	number of sub levels for menus. used for [`wp_nav_menu`](https://developer.wordpress.org/reference/functions/wp_nav_menu/) `depth` args

#### Subdirectory Sidebars

These fields are used to add widget areas to pages and all their descendants. This will not display if the page has its own custom menu tho

*	**Sidebar Name**

	A name for the sidebar, from this name, will be a formatted name for the register sidebar in lowercase. **Please make sure that this value is unique**

* **Pages**

	List of pages that will default to the sidebar including its descendants

### Page Settings

*	**Sidebar Title**

	Duh. Will default to **Default Title** if empty.
	
	Will not output if **Sidebar Menu** is not set

*	**Sidebar Menu**

	Duh.
	
	Will default to nearest ancestors set sidebar

	If that does not exist, will default to the plugin implemented sidebar instead


# Version Updates
*	2.0.4
	- I updated it because i did a dumb thing
	- friendly text bug

*	2.0.3
	- hold my fuck i messed up the blog sidebar
*	2.0.2
	- o wait there's more bugs hahaha wow my butthole is sad but at least it fixed
*	2.0.1
	- depth was not working. fixed
*	2.0.0
	- easier set up and stuff
	- updated quick fields again to 3.0.1.
	- ... and then rolled back because the plugin has some personal issues huhuhu
	- made a documentation mhmm
*	1.0.1 
	- update acf-quickedit-fields 2.4.19 something. the old one yes.
*	1.0.0
	- it born