<?php

declare(strict_types=1);

/**
 * Copyright (c) 2013-2017 OpenCFP
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Test\Integration\Http\Action\Reviewer;

use Illuminate\Database\Eloquent;
use OpenCFP\Domain\Model;
use OpenCFP\Test\Integration\RequiresDatabaseReset;
use OpenCFP\Test\Integration\WebTestCase;

final class DashboardActionTest extends WebTestCase implements RequiresDatabaseReset
{
    /**
     * @test
     */
    public function indexDisplaysListOfTalks()
    {
        /** @var Eloquent\Collection|Model\Talk[] $talks */
        $talks = factory(Model\Talk::class, 2)->create();

        $response = $this
            ->asReviewer()
            ->get('/reviewer/');

        $this->assertResponseIsSuccessful($response);

        foreach ($talks as $talk) {
            $this->assertResponseBodyContains($talk->title, $response);
        }

        $this->assertSessionHasNoFlashMessage($this->session());
    }
}