<?php

declare(strict_types=1);

/**
 * @copyright 2018 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @author 2018 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\FilesRecommendation\Service;

use OCP\Files\Node;

class RecommendedFile implements IRecommendation {

	/** @var Node */
	private $node;

	/** @var int */
	private $timestamp;

	/** @var RecommendationType */
	private $type;

	public function __construct(Node $node,
								int $timestamp,
								RecommendationType $type) {
		$this->node = $node;
		$this->type = $type;
		$this->timestamp = $timestamp;
	}

	public function getTimestamp(): int {
		return $this->timestamp;
	}

	public function getNode(): Node {
		return $this->node;
	}

	public function getType(): RecommendationType {
		return $this->type;
	}

}
