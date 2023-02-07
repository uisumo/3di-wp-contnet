<?php
/**
 * Copyright (c) 2012-2022 David J Bullock
 * Web Power and Light
 */

 class_exists('m4is_emz57o') || die();   
function memb_getContactId() : int { return (int) m4is_lpl4d::m4is_a_2z(); }  
function memb_getContactIdByUserId(int $user_id) : int { return (int) m4is_zbyh::m4is_fhxr6( $user_id ); }  
function memb_getUserIdByContactId(int $contact_id) : int { return m4is_zbyh::m4is__nfdz9($contact_id); }   
function memb_hasAnyTags($tags, $contact_id = false) : bool { if ((! $contact_id) && memberium_app()->m4is_fop0d() ) { return true; } if (! $contact_id) { $contact_id = isset($_SESSION['keap']['contact']['id']) ? $_SESSION['keap']['contact']['id'] : 0; } if ($contact_id) { $m4is_bepwg = isset($_SESSION['keap']['contact']['id']) ? $_SESSION['keap']['contact']['id'] == $contact_id : false; if ($m4is_bepwg) { $contact_tags = isset($_SESSION['keap']['contact']['groups']) ? $_SESSION['keap']['contact']['groups'] : ''; } else { $contact_tags = m4is_zbyh::m4is_w1bfmt($contact_id)['Groups']; } if (! empty($contact_tags)) { return memberium_app()->m4is_c8ie6($tags, $contact_tags); } } return false; }  
function memb_hasAllTags($tags, $contact_id = false) : bool { return memberium_app()->m4is_p04z($tags, $contact_id); }   
function memb_hasAnyMembership() : bool { return m4is_pcys::m4is_a6x52r()->m4is__p8wt3(); }  
function memb_hasMembership( string $level_name ) : bool { return m4is_pcys::m4is_a6x52r()->m4is_eypz($level_name); }  
function memb_hasMembershipLevel( int $level) : bool { return m4is_pcys::m4is_a6x52r()->m4is_tgf3to($level); }   
function memb_overrideProhibitedAction( string $action = 'default' ) { return m4is_pcys::m4is_a6x52r()->m4is__wni( $action ); }  
function memb_isPostProtected( $post ) : bool { return m4is_pcys::m4is_a6x52r()->m4is_ej74k( $post ); }  
function memb_hasPostAccess( int $post_id, int $user_id = 0 ) : bool { return m4is_pcys::m4is_a6x52r()->m4is_whka( $post_id, $user_id ); }  
function memb_hasTermAccess(int $term_id, $taxonomy) : bool { return m4is_bqb1::m4is_a6x52r()->m4is_okxibm( $term_id, $taxonomy ); }   
function memb_changeContactEmail( string $email, int $user_id, bool $force_username = null ) : bool { return (bool) memberium_app()->m4is_yvxkt( $user_id, $email, 0, $force_username ); }  
function memb_changeContactPassword( string $new_password, int $contact_id = 0 ) : bool { return (bool) memberium_app()->m4is_z4o9( $new_password, $contact_id ); }   
function memb_setContactField( string $key, $value, int $contact_id = 0) : bool { if ( empty( $key ) ) { return false; } return (bool) memberium_app()->m4is_g1svi( $key, $value, $contact_id ); }  
function memb_getContactField( string $fieldname, bool $sanitize = false ) { return (string) m4is_pcys::m4is_a6x52r()->m4is_gnk8qe( $fieldname, $sanitize ); }  
function memb_loadContactById( int $contact_id ) : array { return (array) m4is_zbyh::m4is_w1bfmt( $contact_id ); }  
function memb_syncContact( int $contact_id, bool $cascade = false ) : bool { return (bool) memberium_app()->m4is_qjrxkl( $contact_id, $cascade ); }  
function memb_setTags( $tags, int $contact_id = 0, bool $force = false) : bool { return (bool) memberium_app()->m4is__mkz( $tags, $contact_id, $force ); }  
function memb_getSession( int $user_id ) : array { return (isset($_SESSION['memb_user']['user_id']) && $_SESSION['memb_user']['user_id'] == (int) $user_id) ? $_SESSION : memberium_app()->elf_get_session($user_id); }  
function memb_getAffiliateField( string $fieldname, bool $sanitize = false ) : bool { return (bool) m4is_pcys::m4is_a6x52r()->m4is_hxmi3a( $fieldname, $sanitize ); }   
function memb_runActionset( $actionset_ids = '', int $contact_id = 0 ) : bool { return (bool) memberium_app()->m4is_evrbh( $actionset_ids, $contact_id ); }  
function memb_getReceipt( array $args = []) : array { return memberium_app()->m4is_m92l( $args ); }   
function memb_getUserFields(string $field_name, int $user_id = 0) { return m4is_lpl4d::m4is_seig6($field_name, $user_id); }  
function memb_setUserField(string $field_name, $value, int $user_id = 0) { return m4is_lpl4d::m4is_nzco4j($field_name, $value, $user_id); }  
function memb_getMembershipMap() : array { return memberium_app()->m4is_mmdrl('memberships'); } 
function memb_getTagMap( bool $cache_bust = false, bool $negatives = false ) : array { return memberium_app()->m4is_ee0h($cache_bust,$negatives); } 
function memb_getContactFieldsMap() : array { return m4is_f84s3h::m4is_cm6nr( 'Contact', false ); } 
function memb_createTag( $tag_name, $category_id = 0, $description = 'Created by Memberium PHP API' ) { $tag_name = trim( $tag_name ); $category_id = (int) $category_id; $description = trim( $description ); return memberium_app()->m4is_jxy4gf( $tag_name, $category_id, $m4is_ivm3qw ); } 
function memb_loadPostPermissions( int $post_id ) { return m4is_qmpq8::m4is_utcaxj( $post_id ); } 
function memb_savePostPermissions( int $post_id, $permissions, $value = null ) { return m4is_qmpq8::m4is_mp57d( $post_id, $permissions, $value ); }   
function memb_get_keap_api() { return memberium_app()->m4is_wnlbj_(); } 
function memb_getAppName() : string { return memberium_app()->m4is_re5x('appname'); }  
function memb_getPostSettings( int $post_id ) { return m4is_qmpq8::m4is_utcaxj($post_id); } 
function memb_get_license_status() : string { return m4is_o5aoir::m4is_du5icq(); } 
function memb_has_license_tags( $tags ) : bool { $tags = is_array($tags) ? $tags : explode(',', $tags); return m4is_o5aoir::m4is_m4q_z($tags); } 
function memb_is_license_trial() : bool { return m4is_o5aoir::m4is_cgoarf(); }   
function memb_getLoggedIn() : bool { return is_user_logged_in(); }  
function memb_is_loggedin() : bool { return is_user_logged_in(); }  
function memb_doShortcode( string $content, bool $do_regular_shortcodes = true ) : string { return do_shortcode($content); } 
function doMemberiumLogin( string $username, string $password = '', bool $idempotent = false ) { return m4is_pewcid::m4is_l8gbs($username, $password, $idempotent); } 
function memb_setSSOMode( bool $mode = true ) { return memberium_app()->m4is_d8glp6($mode); }
