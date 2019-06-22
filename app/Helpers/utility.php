<?php 

if (!function_exists('setActiveMenu'))
{
    function setActiveMenu( $uri, $output = "current-page" )
    {
        if ( is_array( $uri ) )
        {
            foreach ( $uri as $u ) 
            {
                if ( Route::is( $u ) ) return $output;
            }		
        }
        return Request::is( $uri ) ? $output : 'false';
    }
}

if (!function_exists('getPicture'))
{
    function getPicture($image, $retrun = 'default.jpg')
    {
        return $image ?? $retrun;
    }
}

if (!function_exists('rupiah'))
{
    function rupiah($angka, $m = 'Rp ')
    {
        return $m . number_format($angka, 2, ',', '.');
    }
}

if (!function_exists('identitas')) 
{
    function identitas() 
    {
        return DB::table('identitas')->get()->first();
    }
}

if (!function_exists('anggota')) 
{
    function anggota($userId) 
    {
        return DB::table('anggota')->where('user_id', $userId)->first();
    }
}

