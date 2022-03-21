<?php

declare(strict_types=1);

namespace App\Core\Application\Command\Review\CreateReview;

class CreateReviewCommand
{
    private string $movieId;

    private string $userId;

    private string $title;

    private string $content;

    public function __construct(
        string $movieId,
        string $userId,
        string $title,
        string $content
    )
    {
        $this->movieId = $movieId;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
    }

    public function movieId(): string
    {
        return $this->movieId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }
}
