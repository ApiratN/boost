<?php

declare(strict_types=1);

namespace Laravel\Boost\Install;

use Illuminate\Support\Collection;
use Laravel\Boost\Support\Composer;

class ThirdPartyPackage
{
    public string $name;
    public bool $hasGuidelines;
    public bool $hasSkills;

    public function __construct(string $name, bool $hasGuidelines, bool $hasSkills)
    {
        $this->name = $name;
        $this->hasGuidelines = $hasGuidelines;
        $this->hasSkills = $hasSkills;
    }

    /**
     * Discover all third-party packages with boost features.
     *
     * @return Collection<string, ThirdPartyPackage>
     */
    public static function discover(): Collection
    {
        $withGuidelines = Composer::packagesDirectoriesWithBoostGuidelines();
        $withSkills = Composer::packagesDirectoriesWithBoostSkills();

        $allPackageNames = array_unique(array_merge(
            array_keys($withGuidelines),
            array_keys($withSkills)
        ));

        return collect($allPackageNames)
            ->mapWithKeys(function (string $name): array {
                return [
                    $name => new self(
                        $name,
                        isset($withGuidelines[$name]),
                        isset($withSkills[$name])
                    ),
                ];
            });
    }

    public function featureLabel(): string
    {
        if ($this->hasGuidelines && $this->hasSkills) {
            return 'guidelines, skills';
        }

        if ($this->hasGuidelines) {
            return 'guideline';
        }

        if ($this->hasSkills) {
            return 'skills';
        }

        return '';
    }

    public function displayLabel(): string
    {
        return "{$this->name} ({$this->featureLabel()})";
    }
}
