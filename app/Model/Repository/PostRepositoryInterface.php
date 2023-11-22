<?php

namespace Desafiobis2bis\App\Model\Repository;

use Desafiobis2bis\App\Model\Config\Database;

interface PostRepositoryInterface
{
    public function getAllPosts();
    public function registerPost($postContent, $postTitle);
    public function updatePost($id, $title, $content);
    public function deletePost($id);
}