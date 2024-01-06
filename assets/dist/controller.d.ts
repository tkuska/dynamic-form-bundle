import { Controller } from '@hotwired/stimulus';
export default class extends Controller {
    readonly collectionContainerTarget: HTMLInputElement;
    readonly indexValue: string;
    readonly prototypeValue: string;
    static targets: string[];
    static values: {
        index: NumberConstructor;
        prototype: StringConstructor;
    };
    addCollectionElement(): void;
    removeCollectionElement(): void;
}
