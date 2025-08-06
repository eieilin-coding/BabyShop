<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostComponent extends Component
{
    public $title, $content;
    
    public function savePost()
    {
        $this->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
        ]);
        
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        
        // Clear the form
        $this->reset(['title', 'content']);
        
        // Flash message
        session()->flash('message', 'Post created successfully!');
    }
    
    public function render()
    {
        return view('livewire.post-component');
    }
}