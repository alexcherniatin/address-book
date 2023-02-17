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

    private function noContent(): string
    {
        return '
        <tr colspan="7">
            <td>Brak informacji</td>
        </tr>';
    }

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
