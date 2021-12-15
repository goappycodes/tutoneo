<?php

namespace App\Models;

use App\Services\Auth;
use App\Services\PageService;

class PromoCode extends post{

    public $promocode;
    public $user_id;

    const CODE = 'promocode';

   
    public function __construct($promocode){
        $this->promocode = $promocode;
        $this->user_id = get_current_user_id(); 
    }

    public function check_if_exist(){
    
        $status =  'false';
        if (!PageService::is_current_page(Page::TOP_UP_PAYMENT)) {
            return;
        }
        
        $promocode_to_store = $this->promocode;
        
        $promo_list     = get_user_meta($this->user_id,"promocode",true );
        $promo_list     = !empty($promo_list) ? $promo_list : [];
        
        if(in_array($promocode_to_store , $promo_list)){
            $status =  'true';
        }
        return $status;
    }

    public function add_promo_code(){
        $promocode_to_store = $this->promocode;

        // $promo_list     = get_user_meta($this->user_id,"promocode",true );
        $user = Auth::user();
        $promo_list = $user->get_meta(PromoCode::CODE);
        
        $promo_list     = !empty($promo_list) ? $promo_list : [];

        $promo_arr = ( is_array( $promo_list ) ) ? $promo_list : array( $promo_list );  // Added in case current value is not an array already.
        $promo_arr[] = $promocode_to_store;
        
        
        $user->update_meta_set([
            PromoCode::CODE => $promo_arr,
        ]);
        redirect_to(get_page_url(Page::STUDENT_DASHBOARD) . '?payment=true&status=success&alert=1');
    }
}