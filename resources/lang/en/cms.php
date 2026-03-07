<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CMS — Feature Management (features/index)
    |--------------------------------------------------------------------------
    */

    'features' => [
        'title' => 'Feature Management',
        'card_title' => 'CMS Feature Management',
        'card_desc' => 'Manage all features displayed on the website',
        'add_button' => 'Add Feature',

        // Table headers
        'col_name' => 'Feature Name',
        'col_type' => 'Menu Type',
        'col_sub_count' => 'Sub Features',
        'col_order' => 'Order',
        'col_action' => 'Action',

        // Badges
        'type_dropdown' => 'Dropdown',
        'type_link' => 'Link',

        // Buttons
        'detail' => 'Detail',

        // Empty state
        'empty' => 'No features yet. Click "+ Add Feature" to create one.',

        // Edit modal
        'edit_title' => 'Edit Feature',

        // Add modal
        'add_title' => 'Add New Feature',

        // Delete modal
        'delete' => [
            'title' => 'Delete Feature',
            'confirm' => 'Are you sure you want to delete the feature :name? This action cannot be undone.',
            'yes' => 'Yes, Delete',
        ],

        // Form labels (shared between add/edit)
        'form' => [
            'name' => 'Feature Name',
            'type' => 'Menu Type',
            'path' => 'Path / URL',
            'path_placeholder' => 'Example: /home',
            'order' => 'Order',
            'name_placeholder' => 'Example: Home',
        ],

        // Detail page (features/show)
        'detail_title' => 'Feature Detail: :name',
        'type_label' => 'Type',

        // Sub-menu section (dropdown type)
        'sub' => [
            'list_title' => 'Sub Menu List — :name',
            'list_desc' => 'Manage sub menus within the :name menu',
            'add_button' => 'Add Sub Menu',
            'col_name' => 'Sub Menu Name',
            'col_path' => 'Path / URL',
            'col_order' => 'Order',
            'col_action' => 'Action',
            'empty' => 'No sub menus yet. Click "+ Add Sub Menu" to create one.',

            // Add sub modal
            'add_title' => 'Add Sub Menu',

            // Edit sub modal
            'edit_title' => 'Edit Sub Menu',

            // Delete sub modal
            'delete' => [
                'title' => 'Delete Sub Menu',
                'confirm' => 'Are you sure you want to delete the sub menu :name?',
                'yes' => 'Yes, Delete',
            ],

            // Sub form labels
            'form' => [
                'name' => 'Sub Menu Name',
                'path' => 'Path / URL',
                'path_placeholder' => 'Example: /profile/history',
                'name_placeholder' => 'Example: History',
                'order' => 'Order',
            ],
        ],

        // Content editor (link type)
        'content' => [
            'title' => 'Page Content Editor — :name',
            'desc' => 'Edit the content displayed on the :name page',
            'label' => 'Page Content',
            'placeholder' => 'Enter HTML or text content for this page...',
            'help' => 'You can use HTML to format the content.',
        ],

        // Flash messages
        'flash' => [
            'sub_added' => 'Sub menu added successfully.',
            'feature_added' => 'Feature added successfully.',
            'feature_updated' => 'Feature updated successfully.',
            'content_saved' => 'Page content saved successfully.',
            'feature_deleted' => 'Feature deleted successfully.',
            'sub_updated' => 'Sub feature updated successfully.',
            'sub_deleted' => 'Sub feature deleted successfully.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CMS — Feature Pages
    |--------------------------------------------------------------------------
    */

    'feature_pages' => [
        'title' => 'Page Management — :name',
        'desc' => 'Manage pages displayed for the :name feature',
        'add_button' => 'Add Page',
        'back_to_feature' => 'Back to Feature',

        'col_title' => 'Page Title',
        'col_sections' => 'Sections',
        'col_order' => 'Order',
        'col_action' => 'Action',

        'empty' => 'No pages yet. Click "+ Add Page" to create one.',

        'add_title' => 'Add New Page',
        'edit_title' => 'Edit Page',

        'delete' => [
            'title' => 'Delete Page',
            'confirm' => 'Are you sure you want to delete the page :name?',
            'yes' => 'Yes, Delete',
        ],

        'form' => [
            'title' => 'Page Title',
            'title_placeholder' => 'Example: Contemporary Exhibition',
            'description' => 'Page Description',
            'description_placeholder' => 'Brief description of this page...',
            'order' => 'Order',
        ],

        // Sections
        'sections_title' => 'Page Sections — :name',
        'sections_desc' => 'Manage content sections on the :name page',
        'add_section' => 'Add Section',
        'add_section_title' => 'Add New Section',
        'edit_section_title' => 'Edit Section',

        'section_form' => [
            'title' => 'Section Title',
            'title_placeholder' => 'Example: Mini Diorama Facility',
            'description' => 'Description',
            'description_placeholder' => 'Section description...',
            'images' => 'Images (max. 8)',
            'images_help' => 'Upload JPG/PNG/WebP images, max 2MB per file',
            'existing_images' => 'Current Images',
            'order' => 'Order',
        ],

        'delete_section' => [
            'title' => 'Delete Section',
            'confirm' => 'Are you sure you want to delete the section :name?',
            'yes' => 'Yes, Delete',
        ],

        'flash' => [
            'page_added' => 'Page added successfully.',
            'page_updated' => 'Page updated successfully.',
            'page_deleted' => 'Page deleted successfully.',
            'section_added' => 'Section added successfully.',
            'section_updated' => 'Section updated successfully.',
            'section_deleted' => 'Section deleted successfully.',
        ],

        // Public page
        'welcome' => 'Welcome to the :name portal,',
        'search_placeholder' => 'Search',
        'list_title' => ':name List',
    ],

    /*
    |--------------------------------------------------------------------------
    | CMS — Home Editor (home/edit)
    |--------------------------------------------------------------------------
    */

    'home' => [
        'title' => 'Home Page Content Editor',
        'desc' => 'Manage all content displayed on the Home page of the website',
        'view_page' => 'View Page',

        'hero' => [
            'title' => 'Hero Section (Main Banner)',
            'desc' => 'Main text and CTA button at the top of the page',
            'hero_title' => 'Hero Title',
            'hero_cta' => 'CTA Button Text',
        ],

        'feature_strip' => [
            'title' => 'Feature Strip (Below Hero Banner)',
            'desc' => 'Two information boxes below the hero',
            'left' => 'Left Text',
            'middle' => 'Middle Button',
            'right_button' => 'Right Button',
            'right_text' => 'Right Text',
        ],

        'info' => [
            'title' => 'DABB Information Section',
            'desc' => 'Title and two paragraphs of information about DABB',
            'section' => 'Section Title',
            'paragraph1' => 'Paragraph 1',
            'paragraph2' => 'Paragraph 2',
        ],

        'activities' => [
            'title' => 'Archival Activities Section',
            'desc' => '6 activity items displayed in colored cards',
            'section' => 'Section Title',
        ],

        'section_titles' => [
            'title' => 'Other Section Titles',
            'desc' => 'Titles for Gallery, Statistics, YouTube, Instagram sections, etc.',
            'related' => 'Related Links',
            'gallery' => 'Archive Exhibition (Gallery)',
            'stats' => 'Visitor Statistics',
            'youtube' => 'YouTube',
            'instagram' => 'Instagram Feed',
        ],

        'stats' => [
            'title' => 'Statistics Labels',
            'desc' => 'Text labels for visitor statistics counters',
            'total' => 'Total Visitors Label',
            'today' => 'Today\'s Visitors Label',
        ],

        'youtube' => [
            'title' => 'YouTube Videos',
            'desc' => 'YouTube video IDs displayed in the carousel (format: ID only, example: F2NhNTiNxoY)',
            'video_label' => 'Video :number',
            'placeholder' => 'YouTube ID',
            'help' => 'Copy the ID from the YouTube URL: youtube.com/watch?v=<strong>ID_HERE</strong>',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Common (shared across CMS pages)
    |--------------------------------------------------------------------------
    */

    'common' => [
        'cancel' => 'Cancel',
        'save_changes' => 'Save Changes',
        'save_content' => 'Save Content',
        'back' => 'Back',
        'required' => '*',
    ],

];
