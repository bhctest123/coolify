<?php

namespace App\Livewire\Server;

use App\Models\Server;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;
    public ?Server $server = null;
    public $parameters = [];
    public function mount()
    {
        $this->parameters = get_route_parameters();
        try {
            $this->server = Server::ownedByCurrentTeam()->whereUuid(request()->server_uuid)->first();
            if (is_null($this->server)) {
                return $this->redirectRoute('server.all', navigate: true);
            }

        } catch (\Throwable $e) {
            return handleError($e, $this);
        }
    }
    public function submit()
    {
        $this->dispatch('serverRefresh',false);
    }
    public function render()
    {
        return view('livewire.server.show');
    }
}
