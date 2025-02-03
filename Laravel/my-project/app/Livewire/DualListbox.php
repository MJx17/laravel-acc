<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DualListbox extends Component
{
    public $availableSubjects = [];
    public $selectedSubjects = [];

    public function mount($subjects)
    {
        // Initialize the available subjects (you can modify this to pull from a database or model)
        $this->availableSubjects = $subjects;
    }

    public function moveToSelected($subjectId)
    {
        // Move subject from available to selected
        $subject = $this->findSubjectById($subjectId);
        $this->selectedSubjects[] = $subject;
        $this->availableSubjects = array_filter($this->availableSubjects, fn($item) => $item['id'] !== $subjectId);
    }

    public function moveToAvailable($subjectId)
    {
        // Move subject from selected to available
        $subject = $this->findSubjectById($subjectId, 'selected');
        $this->availableSubjects[] = $subject;
        $this->selectedSubjects = array_filter($this->selectedSubjects, fn($item) => $item['id'] !== $subjectId);
    }

    private function findSubjectById($id, $list = 'available')
    {
        $listToSearch = $list === 'available' ? $this->availableSubjects : $this->selectedSubjects;
        return collect($listToSearch)->first(fn($subject) => $subject['id'] === $id);
    }

    public function render()
    {
        return view('livewire.dual-listbox');
    }
}
