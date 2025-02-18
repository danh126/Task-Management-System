<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface ProjectRepositoryInterface
{
    public function getProjects();
    public function getProject($projectId);
    public function getProjectByManager($managerId);
    public function createProject(Request $request);
    public function updateProject($projectId, Request $request);
    public function deleteProject($projectId);
}
