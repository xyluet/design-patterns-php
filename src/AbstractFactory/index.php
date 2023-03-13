<?php

declare(strict_types=1);

interface TitleTemplate
{
    public function getTemplateString(): string;
}

interface PageTemplate
{
    public function getTemplateString(): string;
}

interface TemplateRenderer
{
    public function render(string $templateString, array $arguments = []): string;
}


interface TemplateFactoryInterface
{
    public function createTitleTemplate(): TitleTemplate;

    public function createPageTemplate(): PageTemplate;

    public function getRenderer(): TemplateRenderer;
}



class TwigTemplateFactory implements TemplateFactoryInterface
{

    public function createTitleTemplate(): TitleTemplate
    {
        return new TwigTitleTemplate();
    }

    public function createPageTemplate(): PageTemplate
    {
        return new TwigPageTemplate();
    }

    public function getRenderer(): TemplateRenderer
    {
        return new TwigRenderer();
    }
}

class TwigTitleTemplate implements TitleTemplate
{
    public function getTemplateString(): string
    {
        return "<h1>{{ title }}</h1>";
    }
}

class TwigPageTemplate implements PageTemplate
{
    public function getTemplateString(): string
    {
        return "<h1>{{ title }}</h1>";
    }
}

class TwigRenderer implements TemplateRenderer
{
    public function render(string $templateString, array $arguments = []): string
    {
        return "string";
    }
}

class Page
{
    private $title;
    private $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render(TemplateFactoryInterface $templateFactory): string
    {
        $pageTemplate = $templateFactory->createPageTemplate();

        $renderer = $templateFactory->getRenderer();

        return $renderer->render($pageTemplate->getTemplateString(), [
            "title" => $this->title,
            "content" => $this->content,
        ]);
    }
}

$page = new Page("title", "content");

echo $page->render(new TwigTemplateFactory());
