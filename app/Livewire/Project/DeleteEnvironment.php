<?php

namespace App\Livewire\Project;

use App\Models\Environment;
use Livewire\Component;

class DeleteEnvironment extends Component
{
    public array $parameters;
    public int $environment_id;

    public function mount()
    {
        $this->parameters = get_route_parameters();
    }

    public function delete()
    {
        $this->validate([
            'environment_id' => 'required|int',
        ]);
        $environment = Environment::findOrFail($this->environment_id);
        if ($environment->isEmpty()) {
            $environment->delete();
            return $this->redirectRoute('project.show', ['project_uuid' => $this->parameters['project_uuid']], navigate: true);
        }
        return $this->dispatch('error', 'Environment has defined resources, please delete them first.');
    }
}
