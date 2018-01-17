pragma solidity ^0.4.4;

contract GreatContract {
    address private contractOwner;
    uint256 private tokenPrice;
    uint256 private numberOfAllTokens;
    uint256 private numberOfAvailableTokens;
    uint256 private numberOfSoldTokens;
    mapping(address => uint256) private purchasers;

    function GreatContract() public {
        contractOwner = msg.sender;
        tokenPrice = 0.79 ether;
        numberOfAllTokens = 12;
        numberOfAvailableTokens = numberOfAllTokens;
        numberOfSoldTokens = 0;
    }

    function() private payable {
        revert();
    }

    modifier OnlyContractOwner {
        require(msg.sender == contractOwner);
        _;
    }

    function buyTokens(uint256 sum) external payable {
        uint256 amount = sum / tokenPrice;
        require(sum % tokenPrice == 0 && amount <= numberOfAvailableTokens);
        purchasers[msg.sender] += amount;
        numberOfSoldTokens += amount;
        numberOfAvailableTokens -= amount;
    }

    function getContractOwner() external constant returns (address) {
        return (contractOwner);
    }

    function getNumberOfTokens(address _address) external constant returns (uint256) {
        return purchasers[_address];
    }

    function getTokenPrice() external constant returns (uint256) {
        return (tokenPrice);
    }

    function setTokenPrice(uint256 value) external OnlyContractOwner {
        tokenPrice = value;
    }

    function getNumberOfAllTokens() external OnlyContractOwner constant returns (uint256) {
        return numberOfAllTokens;
    }

    function getNumberOfAvailableTokens() external OnlyContractOwner constant returns (uint256) {
        return numberOfAvailableTokens;
    }

    function getNumberOfSoldTokens() external OnlyContractOwner constant returns (uint256) {
        return numberOfSoldTokens;
    }

    function setNumberOfAllTokens(uint256 value) external OnlyContractOwner {
        require(value >= numberOfSoldTokens);
        numberOfAllTokens = value;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }

    function setContractOwner(address _address) external OnlyContractOwner {
        contractOwner = _address;
    }
}