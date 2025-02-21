<?php
namespace App\Models;

use CodeIgniter\Model;

class OptionsModel extends Model
{
    protected $table = 'tournament_options';

    protected $primaryKey = 'id';

    protected $allowedFields = ['key', 'value'];

    protected $useTimestamps = false;

    public function updateOrInsertLimit($key, $value)
    {
        $existing = $this->where('key', $key)->first();

        if ($existing) {
            return $this->where('key', $key)->set(['value' => $value])->update();
        } else {
            return $this->insert(['key' => $key, 'value' => $value]);
        }
    }
}