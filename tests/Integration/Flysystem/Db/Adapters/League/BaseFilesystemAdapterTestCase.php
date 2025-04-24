<?php

namespace Aedart\Tests\Integration\Flysystem\Db\Adapters\League;

use Codeception\Attribute\DataProvider;
use League\Flysystem\AdapterTestUtilities\FilesystemAdapterTestCase;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\Test;

/**
 * Base Filesystem Adapter Test Case
 *
 * @see https://github.com/thephpleague/flysystem/issues/1867
 * @see FilesystemAdapterTestCase
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Flysystem\Db\Adapters\League
 */
abstract class BaseFilesystemAdapterTestCase extends FilesystemAdapterTestCase
{
    // TODO: This "base" test-case will be removed in a future version, once
    // TODO: the original has been upgraded to support PHPUnit v12.x.
    // TODO: @see https://github.com/thephpleague/flysystem/issues/1867

    /**
     * @after
     */
    #[After]
    public function cleanupAdapter(): void
    {
        parent::cleanupAdapter();
    }

    /**
     * @test
     */
    #[Test]
    public function writing_and_reading_with_string(): void
    {
        parent::writing_and_reading_with_string();
    }

    /**
     * @test
     */
    #[Test]
    public function writing_a_file_with_a_stream(): void
    {
        parent::writing_a_file_with_a_stream();
    }

    /**
     * @test
     *
     * @dataProvider filenameProvider
     */
    #[DataProvider('filenameProvider')]
    #[Test]
    public function writing_and_reading_files_with_special_path(string $path): void
    {
        parent::writing_and_reading_files_with_special_path($path);
    }

    /**
     * @test
     */
    #[Test]
    public function writing_a_file_with_an_empty_stream(): void
    {
        parent::writing_a_file_with_an_empty_stream();
    }

    /**
     * @test
     */
    #[Test]
    public function reading_a_file(): void
    {
        parent::reading_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function reading_a_file_with_a_stream(): void
    {
        parent::reading_a_file_with_a_stream();
    }

    /**
     * @test
     */
    #[Test]
    public function overwriting_a_file(): void
    {
        parent::overwriting_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function a_file_exists_only_when_it_is_written_and_not_deleted(): void
    {
        parent::a_file_exists_only_when_it_is_written_and_not_deleted();
    }

    /**
     * @test
     */
    #[Test]
    public function listing_contents_shallow(): void
    {
        parent::listing_contents_shallow();
    }

    /**
     * @test
     */
    #[Test]
    public function checking_if_a_non_existing_directory_exists(): void
    {
        parent::checking_if_a_non_existing_directory_exists();
    }

    /**
     * @test
     */
    #[Test]
    public function checking_if_a_directory_exists_after_writing_a_file(): void
    {
        parent::checking_if_a_directory_exists_after_writing_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function checking_if_a_directory_exists_after_creating_it(): void
    {
        parent::checking_if_a_directory_exists_after_creating_it();
    }

    /**
     * @test
     */
    #[Test]
    public function listing_contents_recursive(): void
    {
        parent::listing_contents_recursive();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_file_size(): void
    {
        parent::fetching_file_size();
    }

    /**
     * @test
     */
    #[Test]
    public function setting_visibility(): void
    {
        parent::setting_visibility();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_file_size_of_a_directory(): void
    {
        parent::fetching_file_size_of_a_directory();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_file_size_of_non_existing_file(): void
    {
        parent::fetching_file_size_of_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_last_modified_of_non_existing_file(): void
    {
        parent::fetching_last_modified_of_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_visibility_of_non_existing_file(): void
    {
        parent::fetching_visibility_of_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_the_mime_type_of_an_svg_file(): void
    {
        parent::fetching_the_mime_type_of_an_svg_file();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_mime_type_of_non_existing_file(): void
    {
        parent::fetching_mime_type_of_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_unknown_mime_type_of_a_file(): void
    {
        parent::fetching_unknown_mime_type_of_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function listing_a_toplevel_directory(): void
    {
        parent::listing_a_toplevel_directory();
    }

    /**
     * @test
     */
    #[Test]
    public function writing_and_reading_with_streams(): void
    {
        parent::writing_and_reading_with_streams();
    }

    /**
     * @test
     */
    #[Test]
    public function setting_visibility_on_a_file_that_does_not_exist(): void
    {
        parent::setting_visibility_on_a_file_that_does_not_exist();
    }

    /**
     * @test
     */
    #[Test]
    public function copying_a_file(): void
    {
        parent::copying_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function copying_a_file_that_does_not_exist(): void
    {
        parent::copying_a_file_that_does_not_exist();
    }

    /**
     * @test
     */
    #[Test]
    public function copying_a_file_again(): void
    {
        parent::copying_a_file_again();
    }

    /**
     * @test
     */
    #[Test]
    public function moving_a_file(): void
    {
        parent::moving_a_file();
    }

    /**
     * @test
     */
    #[Test]
    public function file_exists_on_directory_is_false(): void
    {
        parent::file_exists_on_directory_is_false();
    }

    /**
     * @test
     */
    #[Test]
    public function directory_exists_on_file_is_false(): void
    {
        parent::directory_exists_on_file_is_false();
    }

    /**
     * @test
     */
    #[Test]
    public function reading_a_file_that_does_not_exist(): void
    {
        parent::reading_a_file_that_does_not_exist();
    }

    /**
     * @test
     */
    #[Test]
    public function moving_a_file_that_does_not_exist(): void
    {
        parent::moving_a_file_that_does_not_exist();
    }

    /**
     * @test
     */
    #[Test]
    public function trying_to_delete_a_non_existing_file(): void
    {
        parent::trying_to_delete_a_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function checking_if_files_exist(): void
    {
        parent::checking_if_files_exist();
    }

    /**
     * @test
     */
    #[Test]
    public function fetching_last_modified(): void
    {
        parent::fetching_last_modified();
    }

    /**
     * @test
     */
    #[Test]
    public function failing_to_read_a_non_existing_file_into_a_stream(): void
    {
        parent::failing_to_read_a_non_existing_file_into_a_stream();
    }

    /**
     * @test
     */
    #[Test]
    public function failing_to_read_a_non_existing_file(): void
    {
        parent::failing_to_read_a_non_existing_file();
    }

    /**
     * @test
     */
    #[Test]
    public function creating_a_directory(): void
    {
        parent::creating_a_directory();
    }

    /**
     * @test
     */
    #[Test]
    public function copying_a_file_with_collision(): void
    {
        parent::copying_a_file_with_collision();
    }

    /**
     * @test
     */
    #[Test]
    public function moving_a_file_with_collision(): void
    {
        parent::moving_a_file_with_collision();
    }

    /**
     * @test
     */
    #[Test]
    public function copying_a_file_with_same_destination(): void
    {
        parent::copying_a_file_with_same_destination();
    }

    /**
     * @test
     */
    #[Test]
    public function moving_a_file_with_same_destination(): void
    {
        parent::moving_a_file_with_same_destination();
    }

    /**
     * @test
     */
    #[Test]
    public function generating_a_public_url(): void
    {
        parent::generating_a_public_url();
    }

    /**
     * @test
     */
    #[Test]
    public function generating_a_temporary_url(): void
    {
        parent::generating_a_temporary_url();
    }

    /**
     * @test
     */
    #[Test]
    public function get_checksum(): void
    {
        parent::get_checksum();
    }

    /**
     * @test
     */
    #[Test]
    public function cannot_get_checksum_for_non_existent_file(): void
    {
        parent::cannot_get_checksum_for_non_existent_file();
    }

    /**
     * @test
     */
    #[Test]
    public function cannot_get_checksum_for_directory(): void
    {
        parent::cannot_get_checksum_for_directory();
    }
}
