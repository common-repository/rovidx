<?php

class RoVidX_Updater
{
    private $api_url = '';
    private $api_data = array();
    private $name = '';
    private $slug = '';
    function __construct($_api_url, $_plugin_file, $_api_data = null)
    {
        $this->api_url  = trailingslashit($_api_url);
        $this->api_data = urlencode_deep($_api_data);
        $this->name     = plugin_basename($_plugin_file);
        $this->slug     = basename($_plugin_file, '.php');
        $this->version  = $_api_data['version'];
        $this->hook();
    }
    private function hook()
    {
        add_filter('pre_set_site_transient_update_plugins', array(
            $this,
            'pre_set_site_transient_update_plugins_filter'
        ));
        add_filter('plugins_api', array(
            $this,
            'plugins_api_filter'
        ), 10, 3);
        add_filter('http_request_args', array(
            $this,
            'http_request_args'
        ), 10, 2);
    }
    function pre_set_site_transient_update_plugins_filter($_transient_data)
    {
        if (empty($_transient_data))
            return $_transient_data;
        $to_send      = array(
            'slug' => $this->slug
        );
        $api_response = $this->api_request('plugin_latest_version', $to_send);
        if (false !== $api_response && is_object($api_response) && isset($api_response->new_version)) {
            if (version_compare($this->version, $api_response->new_version, '<'))
                $_transient_data->response[$this->name] = $api_response;
        }
        return $_transient_data;
    }
    function plugins_api_filter($_data, $_action = '', $_args = null)
    {
        if (($_action != 'plugin_information') || !isset($_args->slug) || ($_args->slug != $this->slug))
            return $_data;
        $to_send      = array(
            'slug' => $this->slug
        );
        $api_response = $this->api_request('plugin_information', $to_send);
        if (false !== $api_response)
            $_data = $api_response;
        return $_data;
    }
    function http_request_args($args, $url)
    {
        if (strpos($url, 'https://') !== false && strpos($url, 'edd_action=package_download')) {
            $args['sslverify'] = false;
        }
        return $args;
    }
    private function api_request($_action, $_data)
    {
        global $wp_version;
        $data = array_merge($this->api_data, $_data);
        if ($data['slug'] != $this->slug)
            return;
        if (empty($data['license']))
            return;
        $api_params = array(
            'edd_action' => 'get_version',
            'license' => $data['license'],
            'name' => $data['item_name'],
            'slug' => $this->slug,
            'author' => $data['author']
        );
        $request    = wp_remote_post($this->api_url, array(
            'timeout' => 15,
            'sslverify' => false,
            'body' => $api_params
        ));
        if (!is_wp_error($request)):
            $request = json_decode(wp_remote_retrieve_body($request));
            if ($request && isset($request->sections))
                $request->sections = maybe_unserialize($request->sections);
            return $request;
        else:
            return false;
        endif;
    }
}