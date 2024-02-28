<?php

namespace MediaWiki\Extension\ThisIsNotAWiki\Hooks;

class Hider implements
	\MediaWiki\Hook\ParserOutputPostCacheTransformHook,
	\MediaWiki\Hook\SidebarBeforeOutputHook
	// \MediaWiki\Hook\PersonalUrlsHook
{
	/** @inheritDoc */
	public function onParserOutputPostCacheTransform( $parserOutput, &$text,
		&$options
	): void {
		$options['enableSectionEditLinks'] = false;
	}

	/** @inheritDoc */
	public function onSidebarBeforeOutput( $skin, &$sidebar ): void {
		unset( $sidebar['TOOLBOX'] );
		unset( $sidebar['SEARCH'] );
	}

	// /** @inheritDoc */ TODO: Fix, migrating to new Interface wont disable the login button
    // public function onPersonalUrls( &$personal_urls, &$title, $skin ): void {
    // 	   $personal_urls = [];
    // }
}
