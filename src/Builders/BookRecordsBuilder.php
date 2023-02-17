<?php

namespace AddressBook\Builders;

use AddressBook\Core\Utils;
use AddressBook\Dto\BookRecord;

class BookRecordsBuilder
{
    /**
     * Build book records list html
     *
     * @param array<BookRecord> $bookRecords
     *
     * @return string 
     */
    public function buildList(array $bookRecords): string
    {
        if (\count($bookRecords) === 0) {
            return $this->noContent();
        }

        $html = '';

        foreach ($bookRecords as $bookRecord) {
            $html .= $this->buildRecordListItem($bookRecord);
        }

        return $html;
    }

    /**
     * No content information
     * 
     * @return string 
     */
    private function noContent(): string
    {
        return '
        <tr>
            <td colspan="8">Brak informacji <a href="/adress/add/" class="btn btn-primary">Dodaj adres</a></td>
        </tr>';
    }

    /**
     * Build record list item
     *
     * @param BookRecord $bookRecord Book record dto
     *
     * @return string 
     */
    public function buildRecordListItem(BookRecord $bookRecord): string
    {
        $updatedAt = (\is_null($bookRecord->updatedAt))
            ? 'Brak'
            : Utils::dateFromTimestamp($bookRecord->updatedAt);

        return '
        <tr>
            <td>' . $bookRecord->firstName . '</td>
            <td>' . $bookRecord->lastName . '</td>
            <td>' . $bookRecord->email . '</td>
            <td>' . $bookRecord->phone . '</td>
            <td>' . $bookRecord->address . '</td>
            <td>' . Utils::dateFromTimestamp($bookRecord->createdAt) . '</td>
            <td>' . $updatedAt . '</td>
            <td></td>
        </tr>';
    }
}
