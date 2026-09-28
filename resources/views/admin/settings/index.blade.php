@extends('admin.layouts.admin')

@section('title', 'Settings | Upsilon')

@section('page-title', 'Settings')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Application Settings</h3>
            <p class="admin-card-description">Manage application configuration</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div class="admin-form-group">
                <label class="admin-form-label" for="app_name">App Name</label>
                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $data['app_name']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="app_url">App URL</label>
                <input type="url" id="app_url" name="app_url" value="{{ old('app_url', $data['app_url']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="mail_from_address">Mail From Address</label>
                <input type="email" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', $data['mail_from_address']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="mail_from_name">Mail From Name</label>
                <input type="text" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', $data['mail_from_name']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="whatsapp_number">WhatsApp Number</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $data['whatsapp_number']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="whatsapp_default_message">WhatsApp Default Message</label>
                <textarea id="whatsapp_default_message" name="whatsapp_default_message" rows="3" class="admin-form-input">{{ old('whatsapp_default_message', $data['whatsapp_default_message']) }}</textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="instagram_account_id">Instagram Account ID</label>
                <input type="text" id="instagram_account_id" name="instagram_account_id" value="{{ old('instagram_account_id', $data['instagram_account_id']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="instagram_access_token">Instagram Access Token</label>
                <input type="text" id="instagram_access_token" name="instagram_access_token" value="{{ old('instagram_access_token', $data['instagram_access_token']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="instagram_api_version">Instagram API Version</label>
                <input type="text" id="instagram_api_version" name="instagram_api_version" value="{{ old('instagram_api_version', $data['instagram_api_version']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="instagram_api_base_url">Instagram API Base URL</label>
                <input type="url" id="instagram_api_base_url" name="instagram_api_base_url" value="{{ old('instagram_api_base_url', $data['instagram_api_base_url']) }}" class="admin-form-input">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="instagram_cache_ttl">Instagram Cache TTL (seconds)</label>
                <input type="number" id="instagram_cache_ttl" name="instagram_cache_ttl" value="{{ old('instagram_cache_ttl', $data['instagram_cache_ttl']) }}" class="admin-form-input">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn admin-btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection
