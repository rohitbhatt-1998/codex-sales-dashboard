<h1>Settings</h1>
<form method="post" action="<?= url('/settings/save') ?>" class="grid-form">
  <label>Calling Provider
    <select name="call_provider">
      <option value="twilio" <?= (($settings['call_provider'] ?? '') === 'twilio') ? 'selected' : '' ?>>Twilio</option>
      <option value="exotel" <?= (($settings['call_provider'] ?? '') === 'exotel') ? 'selected' : '' ?>>Exotel</option>
    </select>
  </label>

  <label>AI Provider
    <select name="ai_provider">
      <option value="openrouter" <?= (($settings['ai_provider'] ?? '') === 'openrouter') ? 'selected' : '' ?>>OpenRouter</option>
      <option value="cohere" <?= (($settings['ai_provider'] ?? '') === 'cohere') ? 'selected' : '' ?>>Cohere</option>
    </select>
  </label>

  <label>Agent Name <input name="agent_name" value="<?= htmlspecialchars($settings['agent_name'] ?? 'Olama') ?>"></label>
  <label>Twilio SID <input name="twilio_sid" value="<?= htmlspecialchars($settings['twilio_sid'] ?? '') ?>"></label>
  <label>Twilio Token <input name="twilio_token" value="<?= htmlspecialchars($settings['twilio_token'] ?? '') ?>"></label>
  <label>Twilio From <input name="twilio_from" value="<?= htmlspecialchars($settings['twilio_from'] ?? '') ?>"></label>

  <label>Exotel SID <input name="exotel_sid" value="<?= htmlspecialchars($settings['exotel_sid'] ?? '') ?>"></label>
  <label>Exotel Token <input name="exotel_token" value="<?= htmlspecialchars($settings['exotel_token'] ?? '') ?>"></label>
  <label>Exotel From <input name="exotel_from" value="<?= htmlspecialchars($settings['exotel_from'] ?? '') ?>"></label>

  <label>OpenRouter API Key <input name="openrouter_api_key" value="<?= htmlspecialchars($settings['openrouter_api_key'] ?? '') ?>"></label>
  <label>Cohere API Key <input name="cohere_api_key" value="<?= htmlspecialchars($settings['cohere_api_key'] ?? '') ?>"></label>

  <button type="submit">Save Settings</button>
</form>
